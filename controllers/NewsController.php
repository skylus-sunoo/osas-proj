<?php

require_once 'models/NewsModel.php';

class NewsController
{
    private $model;

    public function __construct()
    {
        $this->model = new NewsModel();
    }

    public function index($id = null)
    {
        $data['news_list'] = $this->model->getNews($id);
    }

    public function showLatestNews()
    {
        $CHARACER_LIMIT = 200;
        $dataRaw = $this->model->getLatestNews(2);

        foreach ($dataRaw as $data) {
            echo '<div class="home-news-item">';
            $imagePath = '../../../assets/img/news/' . htmlspecialchars($data['news_ID']) . '.png';
            echo '<img src="' . $imagePath . '" alt="News Image">';
            echo '<h4>' . htmlspecialchars($data['news_Title']) . '</h4>';

            $description = trim($data['news_Description']);
            $description = str_replace(["\r\n", "\n", "\r"], ' ', $description);
            $description = truncate($description, $CHARACER_LIMIT);

            echo '<p>' . htmlspecialchars($description) . '</p>';

            echo '<form action="/dashboard/news" method="post">
                    <input type="hidden" name="news_ID" value="' . htmlspecialchars($data['news_ID']) . '">
                    <button type="submit" class="primary-button" style="float: right; padding: 12px 18px; margin-bottom: 1rem;">READ MORE</button>
                </form>';
            echo '</div>';
        }
    }

    public function showNews($id)
    {
        $dataRaw = $this->model->getNews($id);
        $data = $dataRaw[0] ?? [];

        echo '<section class="home-admission-card">
            <div class="news-image">
                <img src="../../../assets/img/news/' . htmlspecialchars($data['news_ID']) . '.png" alt="News Image">
            </div>
            <h1 class="news-title">' . $data['news_Title'] . '</h1>
            <p class="news-description">' . nl2br($data['news_Description']) . '</p>
        </section>';
    }

    public function showNewsList()
    {
        $TITLE_LIMIT = 65;
        $DESC_LIMIT = 100;
        $NEWS_ITEM_LIMIT = 8;

        $dataRaw = $this->model->getNews();
        // Custom comparison function to sort by 'news_Date'
        usort($dataRaw, function ($a, $b) {
            $dateA = strtotime($a['news_Date']);
            $dateB = strtotime($b['news_Date']);

            // Compare the two dates
            return $dateB - $dateA ;  // Descending order: latest date first
        });

        $dataRaw = array_slice($dataRaw, 0, $NEWS_ITEM_LIMIT);

        foreach ($dataRaw as $data) {
            $id = $data['news_ID'];
            $category = $data['news_Category'];
            $title = truncate($data['news_Title'], $TITLE_LIMIT);
            $desc = truncate($data['news_Description'], $DESC_LIMIT);

            $date = new DateTime($data['news_Date']);
            $formattedDate = $date->format('F j, Y');

            echo '<form action="/dashboard/news" method="post" style="all: unset;">
                <input type="hidden" name="news_ID" value="' . htmlspecialchars($id) . '">
                <button type="submit" class="home-news-link" style="all: unset; cursor: pointer; display: block; width: 100%;">
                    <div class="home-news-list-item">
                        <div class="news-image-container">
                            <img src="../../../assets/img/news/' . $id . '.png" alt="">
                            <div class="news-category">' . htmlspecialchars($category) . '</div>
                        </div>
                        <div>
                            <h6><span class="font-MaterialSymbolsOutlined">calendar_today</span>&nbsp;' . $formattedDate . '</h6>
                            <h3>' . $title . '</h3>
                            <h5>' . $desc . '</h5>
                        </div>
                    </div>
                </button>
            </form>';
        }
    }

    public function getNewsTitle($id)
    {
        $dataRaw = $this->model->getNewsTitle($id);
        $data = $dataRaw[0] ?? [];

        return $this->model->getNewsTitle($id);
    }

    public function renderNewsList()
    {
        // Set the number of items per page and the current page
        $itemsPerPage = 8;
        $currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

        // Calculate the starting row for the SQL query (Offset)
        $startRow = ($currentPage - 1) * $itemsPerPage;

        // Fetch paginated news list data
        global $connections;

        $stmt = mysqli_prepare($connections, "SELECT * FROM `" . TB_NEWS . "` ORDER BY `news_Date` DESC LIMIT ?, ?");
        mysqli_stmt_bind_param($stmt, "ii", $startRow, $itemsPerPage);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $newsList = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $newsList[] = $row;
        }
        mysqli_stmt_close($stmt);

        // Fetch the total number of rows for pagination
        $totalAdmissions = countData(TB_NEWS);  // Fetch all records to count total
        $totalPages = ceil($totalAdmissions / $itemsPerPage);  // Calculate total pages

        $TITLE_LIMIT = 65;
        $DESC_LIMIT = 100;

        echo '<section class="home-news-list">
                <section class="home-news-list-grid">';
        foreach ($newsList as $news) {
            $id = $news['news_ID'];
            $category = $news['news_Category'];
            $title = truncate($news['news_Title'], $TITLE_LIMIT);
            $desc = truncate($news['news_Description'], $DESC_LIMIT);

            $date = new DateTime($news['news_Date']);
            $formattedDate = $date->format('F j, Y');

            echo '<form action="/dashboard/news" method="post" style="all: unset;">
                <input type="hidden" name="news_ID" value="' . htmlspecialchars($id) . '">
                <button type="submit" class="home-news-link" style="all: unset; cursor: pointer; display: block; width: 100%;">
                    <div class="home-news-list-item">
                        <div class="news-image-container">
                            <img src="../../../assets/img/news/' . $id . '.png" alt="">
                            <div class="news-category">' . htmlspecialchars($category) . '</div>
                        </div>
                        <div>
                            <h6><span class="font-MaterialSymbolsOutlined">calendar_today</span>' . $formattedDate . '</h6>
                            <h3>' . $title . '</h3>
                            <h5>' . $desc . '</h5>
                        </div>
                    </div>
                </button>
            </form>';
        }
        echo '</section>
            </section>';

        renderPaginationControls($currentPage, $totalPages, $totalAdmissions);
    }
}
