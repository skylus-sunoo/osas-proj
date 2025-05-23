<?php

class NewsModel
{
    private $table_news = TB_NEWS;

    public function getNews($id = null)
    {
        if ($id === null) {
            return fetchData($this->table_news);
        } else {
            return fetchData($this->table_news, '*', [['news_ID', '=', $id]]);
        }
    }

    public function getNewsTitle($id)
    {
        if (checkForData($this->table_news, [['news_ID', '=', $id]])) {
            return fetchData($this->table_news, 'news_Title', [['news_ID', '=', $id]]);
        }
        return null;
    }

    public function getLatestNews($amount = 2)
    {
        $sql = "SELECT * FROM " . TB_NEWS . "
                ORDER BY news_Date DESC
                LIMIT " . sanitizeInput($amount);

        return runQuery($sql);
    }

    public function getLastInsertedID()
    {
        $sql = "SELECT * FROM " . TB_NEWS . "
                ORDER BY news_ID DESC
                LIMIT 1";

        $result = runQuery($sql);
        if (count($result) > 0) {
            return $result[0]['news_ID'];
        } else {
            return null;
        }
    }

    public function createNews($data)
    {
        insertData($this->table_news, [
            'news_Title',
            'news_Category',
            'news_Date',
            'news_Description'
        ], $data);
    }

    public function updateNews($data, $id)
    {
        if (checkForData($this->table_news, [['news_ID', '=', $id]])) {
            updateData($this->table_news, [
                'news_Title',
                'news_Category',
                'news_Date',
                'news_Description'
            ], $data, [['news_ID', '=', $id]]);
        }
    }

    public function deleteNews($id)
    {
        deleteData($this->table_news, [['news_ID', '=', $id]]);
    }

    public function newsExists($id)
    {
        return checkForData($this->table_news, [['news_ID', '=', $id]]);
    }
}
