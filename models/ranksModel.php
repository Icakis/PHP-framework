<?php

namespace Models;

include_once 'baseModel.php';

class RanksModel extends BaseModel
{
    public function __construct($args = array())
    {
        $args['table'] = 'users_playlist_ranks';
        parent::__construct($args);
    }

    public function rankPlaylist($playlist_id, $user_id, $is_like)
    {
        if (!$playlist_id || !is_int($playlist_id)) {
            throw new \Exception('Invalid playlist id.');
        }

        if (!$user_id || !is_int($user_id)) {
            throw new \Exception('Invalid user id.');
        }

        if (!is_bool($is_like)) {
            throw new \Exception('Invalid vote.');
        } else {
            if ($is_like) {
                $is_like = 1;
                $is_not_like = 0;
            } else {
                $is_like = 0;
                $is_not_like = 1;
            }
        }

        $date_ranked = date("c");
        $statement = $this->dbConnection->prepare(
            "INSERT INTO users_playlist_ranks (user_id, playlist_id, is_like, is_dislike, date_ranked)
            VALUES(?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE
              is_like     = ?,
              is_dislike = ?,
              date_ranked = ?");

        $statement->bind_param("iiiisiis", $user_id, $playlist_id, $is_like, $is_not_like, $date_ranked, $is_like, $is_not_like, $date_ranked);
        $statement->execute();

        return $statement->affected_rows > 0;
    }

    public function isPlaylistLikedByUser($playlist_id, $user_id)
    {
        if (!$playlist_id || !is_int($playlist_id)) {
            throw new \Exception('Invalid playlist id.');
        }

        if (!$user_id || !is_int($user_id)) {
            throw new \Exception('Invalid user id.');
        }

        $statement = $this->dbConnection->prepare(
            "SELECT is_like, is_dislike, date_ranked
            FROM users_playlist_ranks
            WHERE playlist_id = ? AND user_id = ?
            LIMIT 1");
        $statement->bind_param("ii", $playlist_id, $user_id);

        $statement->execute();
        $result_set = $statement->get_result();

        if (empty($result_set)) {
            return null;
        }

        return $result_set->fetch_assoc();
    }

    // Not used
    public function getPlaylistLikesDislikes($playlist_id)
    {
        if (!$playlist_id || !is_int($playlist_id)) {
            throw new \Exception('Invalid playlist id.');
        }

        $statement = $this->dbConnection->prepare(
            "SELECT sum(is_likes)
            FROM users_playlist_ranks
            GROUP BY playlist_id
            HAVING playlist_id = ?");
        $statement->bind_param("i", $playlist_id);

        $statement->execute();
        $result_set = $statement->get_result();

        if (empty($result_set)) {
            return false;
        }

        return $result_set->fetch_row()[0];
    }

    public function rankSong($song_id, $user_id, $is_like)
    {
        if (!$song_id || !is_int($song_id)) {
            throw new \Exception('Invalid song id.');
        }

        if (!$user_id || !is_int($user_id)) {
            throw new \Exception('Invalid user id.');
        }

        if (!is_bool($is_like)) {
            throw new \Exception('Invalid vote.');
        } else {
            if ($is_like) {
                $is_like = 1;
                $is_not_like = 0;
            } else {
                $is_like = 0;
                $is_not_like = 1;
            }
        }

        $date_ranked = date("c");
        $statement = $this->dbConnection->prepare(
            "INSERT INTO users_songs_ranks (user_id, song_id, is_like, is_dislike, date_ranked)
            VALUES(?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE
              is_like     = ?,
              is_dislike = ?,
              date_ranked = ?");

        $statement->bind_param("iiiisiis", $user_id, $song_id, $is_like, $is_not_like, $date_ranked, $is_like, $is_not_like, $date_ranked);
        $statement->execute();

        return $statement->affected_rows > 0;
    }

    public function isSongLikedByUser($song_id, $user_id)
    {
        if (!$song_id || !is_int($song_id)) {
            throw new \Exception('Invalid song id.');
        }

        if (!$user_id || !is_int($user_id)) {
            throw new \Exception('Invalid user id.');
        }

        $statement = $this->dbConnection->prepare(
            "SELECT is_like, is_dislike, date_ranked
            FROM users_songs_ranks
            WHERE song_id = ? AND user_id = ?
            LIMIT 1");
        $statement->bind_param("ii", $song_id, $user_id);
        $statement->execute();
        $result_set = $statement->get_result();

        if (empty($result_set)) {
            return null;
        }

        return $result_set->fetch_assoc();
    }

    public function highRatedPlaylists($first_number = 10)
    {
        $statement = $this->dbConnection->prepare(
            "SELECT
                p.title as title,
                p.id AS playlist_id,
                likes_info.likes_sum AS likes_sum,
                likes_info.dislikes_sum AS dislikes_sum
            FROM playlists p
            JOIN (SELECT
                        playlist_id as pid,
                        SUM(is_like) as likes_sum,
                        SUM(is_dislike) as dislikes_sum
                    FROM php_framework.users_playlist_ranks
                    GROUP BY playlist_id
                    ) likes_info
            ON  likes_info.pid = p.id
            ORDER BY likes_info.likes_sum DESC, likes_info.dislikes_sum ASC
            LIMIT 0, ?");
        $statement->bind_param('i', $first_number);
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
} 