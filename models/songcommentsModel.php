<?php

namespace Models;

include_once 'baseModel.php';

class SongCommentsModel extends BaseModel
{
    public function __construct($args = array())
    {
        $args['table'] = 'songs_comments';
        parent::__construct($args);
    }

    public function songComments($song_id, $offset, $comments_count, $filter = null)
    {
        if ($filter) {
            $statement = $this->dbConnection->prepare(
                "SELECT * FROM songs_comments sc JOIN users u ON sc.user_id = u.id WHERE  song_id = ? AND text LIKE CONCAT('%', ?, '%') ORDER BY sc.date_created ASC  LIMIT ?, ?");
            $statement->bind_param("isii", $song_id, $filter, $offset, $comments_count);
        } else {
            $statement = $this->dbConnection->prepare(
                "SELECT * FROM songs_comments sc JOIN users u ON sc.user_id = u.id WHERE  song_id = ? ORDER BY sc.date_created ASC LIMIT ?, ?");
            $statement->bind_param("iii", $song_id, $offset, $comments_count);
        }

        $statement->execute();
        $result_set = $statement->get_result();

        $results = array();

        if (!empty($result_set) && $result_set->num_rows > 0) {
            while ($row = $result_set->fetch_assoc()) {
                $results[] = $row;
            }
        }

        return $results;
    }

    public function songCommentsCount($song_id, $filter = null)
    {
        if ($filter) {
            $statement = $this->dbConnection->prepare("SELECT count(id) FROM songs_comments WHERE  song_id = ? AND text LIKE CONCAT('%', ?, '%')");
            $statement->bind_param("isii", $song_id, $filter);
        } else {
            $statement = $this->dbConnection->prepare("SELECT count(id) FROM songs_comments WHERE  song_id = ?");
            $statement->bind_param("i", $song_id);
        }

        $statement->execute();
        $result_set = $statement->get_result();

        if (empty($result_set)) {
            return 0;
        }

        return $result_set->fetch_row()[0];
    }


    public function addSongComment($song_id, $user_id, $comment)
    {
        if ($comment == '') {
            throw new \Exception('Cannot create empty playlist comment.');
        }

        if ($song_id == '' || !is_int($song_id)) {
            throw new \Exception('Invalid playlist id.');
        }

        if ($user_id == '' || !is_int($user_id)) {
            throw new \Exception('Invalid user id.');
        }

        $statement = $this->dbConnection->prepare("INSERT INTO songs_comments (song_id, user_id, text, date_created) VALUES(?, ?, ?, ?)");
        $statement->bind_param("iiss", $song_id, $user_id, $comment, date("c"));
        $statement->execute();
        return $statement->affected_rows > 0;
    }
} 