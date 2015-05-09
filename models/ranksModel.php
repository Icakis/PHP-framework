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
        if(!$playlist_id || !is_int($playlist_id)){
            throw new \Exception('Invalid playlist id.');
        }

        if(!$user_id || !is_int($user_id)){
            throw new \Exception('Invalid user id.');
        }

        if(!is_bool($is_like)){
            throw new \Exception('Invalid vote.');
        }

        $date_ranked = date("c");
        $statement = $this->dbConnection->prepare("INSERT INTO users_playlist_ranks (user_id, playlist_id, is_like, is_dislike, date_ranked) VALUES(?, ?, ?, ?, ?)");
        $statement->bind_param("iiiis", $user_id, $playlist_id,$is_like, !$is_like,$date_ranked );
        $statement->execute();

        return $statement->affected_rows > 0;
    }

    public function getPlaylistLikesDislikes($playlist_id)
    {
        if(!$playlist_id || !is_int($playlist_id)){
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

} 