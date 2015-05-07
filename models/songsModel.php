<?php

namespace Models;

include_once 'baseModel.php';

class SongsModel extends BaseModel
{
    public function __construct($args = array())
    {
        $args['table'] = 'songs';
        parent::__construct($args);
    }

    public function getUsersPlaylists($user_id, $offset, $playlists_count)
    {
        $statement = $this->dbConnection->prepare("SELECT * FROM playlists WHERE user_id = ? limit ?, ?");
        $statement->bind_param("iii", $user_id, $offset, $playlists_count);
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

    public function getPlaylistSongs($playlist_id, $offset, $playlists_count)
    {
        $statement = $this->dbConnection->prepare("SELECT * FROM songs WHERE playlist_id = ? limit ?, ? ");
        $statement->bind_param("iii", $playlist_id, $offset, $playlists_count);
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

    public function getPlaylistSongsCount($playlist_id)
    {
        $statement = $this->dbConnection->prepare("SELECT count(id) FROM songs WHERE playlist_id = ?");
        $statement->bind_param("i", $playlist_id);
        $statement->execute();
        $result_set = $statement->get_result();

        if (empty($result_set)) {
            return 0;
        }

        return $result_set->fetch_row()[0];
    }


    public function getAllPublicPlaylists($offset, $playlists_count)
    {
        $statement = $this->dbConnection->prepare("SELECT * FROM playlists JOIN users ON playlists.user_id=users.id WHERE is_private = false limit ?, ? ");
        $statement->bind_param("ii", $offset, $playlists_count);
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


    public function getPublicPlaylistsCount()
    {
        $statement = $this->dbConnection->prepare("SELECT count(id) FROM playlists WHERE is_private = false");
        $statement->execute();
        $result_set = $statement->get_result();

        if (empty($result_set)) {
            return 0;
        }

        return $result_set->fetch_row()[0];
    }

    public function addPlaylist($user_id, $title, $description, $is_private)
    {
        if ($title == '') {
            throw new \Exception('Cannot create Playlist with empty title.');
        }

        if ($user_id == '') {
            throw new \Exception('Invalid user id.');
        }

        $statement = $this->dbConnection->prepare("INSERT INTO playlists (user_id, title, date_created, description, is_private) VALUES(?, ?, ?, ?, ?)");
        $statement->bind_param("issss", $user_id, $title, date("c"), $description, $is_private);
        $statement->execute();
        return $statement->affected_rows > 0;
    }

    public function deletePlaylist($user_id, $playlist_id)
    {
        if ($playlist_id == '' && is_int($playlist_id)) {
            throw new \Exception('Invalid playlist id.');
        }

        if ($user_id == '') {
            throw new \Exception('Invalid user id.');
        }

        $playlist_id =(int)$playlist_id;
        $statement = $this->dbConnection->prepare("DELETE FROM playlists WHERE id = ? and user_id = ?");
        $statement->bind_param("ii", $playlist_id, $user_id);
        $statement->execute();
        return $statement->affected_rows > 0;
    }
} 