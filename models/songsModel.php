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

    public function getPlaylistSongs($playlist_id, $offset, $songs_count, $filter = null)
    {
        $statement = $this->dbConnection->prepare(
            "SELECT s.id AS song_id,
                    s.title AS song_title,
                    s.artist AS song_artist,
                    s.album AS song_album,
                    s.user_id AS user_id,
                    s.date_added,
                    s.playlist_id,
                    s.file_name,
                    s.duration,
                    g.name AS genre_name,
                    gt.name AS genre_type_name,
                    u.username AS username,
                    p.title AS playlist_title,
                    likes_info.likes_sum AS likes_sum,
                    likes_info.dislikes_sum AS dislikes_sum
            FROM songs s
            JOIN users u
              ON s.user_id = u.id
            LEFT JOIN (SELECT
						song_id as pid,
                        SUM(is_like) AS likes_sum,
                        SUM(is_dislike) AS dislikes_sum
                    FROM users_songs_ranks
                    GROUP BY song_id) likes_info
                ON  likes_info.pid = s.id
            LEFT JOIN genres g
              ON s.genre_id = g.id
            LEFT JOIN genres_types gt
              ON s.genre_type_id = gt.id
            LEFT JOIN playlists p
              ON s.playlist_id = p.id
            WHERE playlist_id = ? AND s.title LIKE CONCAT('%', ?, '%')
            LIMIT ?, ?");
        $statement->bind_param("isii", $playlist_id, $filter, $offset, $songs_count);

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

    public function getPlaylistSongsCount($playlist_id, $filter = null)
    {
        if ($filter) {
            $statement = $this->dbConnection->prepare("SELECT count(id) FROM songs WHERE playlist_id = ? AND  title LIKE CONCAT('%', ?, '%')");
            $statement->bind_param("is", $playlist_id, $filter);
        } else {
            $statement = $this->dbConnection->prepare("SELECT count(id) FROM songs WHERE playlist_id = ?");
            $statement->bind_param("i", $playlist_id);
        }

        $statement->execute();
        $result_set = $statement->get_result();

        if (empty($result_set)) {
            return 0;
        }

        return $result_set->fetch_row()[0];
    }


    public function addPlaylistSong($playlist_id, $user_id, $title, $artist, $file_name, $album = NULL, $genre_id = NULL, $genre_type_id = NULL, $duration = '')
    {
        if (!$playlist_id || !is_int($playlist_id)) {
            throw new \Exception('Invalid playlist id.');
        }

        if (!$user_id || !is_int($user_id)) {
            throw new \Exception('Invalid user id.');
        }

        if (!$title) {
            throw new \Exception('Cannot create Song with empty title.');
        }

        if (!$artist) {
            throw new \Exception('Cannot create Song with empty artist.');
        }

        if (!$file_name) {
            throw new \Exception('Invalid file name.');
        }

        if ($genre_id && !is_int($genre_id)) {
            throw new \Exception('Invalid genre id.');
        }

        if ($genre_type_id && !is_int($genre_type_id)) {
            throw new \Exception('Invalid genre type id.');
        }

        $date_added = date("c");
        $statement = $this->dbConnection->prepare("INSERT INTO songs (title, artist, album, playlist_id, user_id, file_name, date_added, duration, genre_id, genre_type_id) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $statement->bind_param("sssiisssss", $title, $artist, $album, $playlist_id, $user_id, $file_name, $date_added, $duration, $genre_id, $genre_type_id);
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

        $playlist_id = (int)$playlist_id;
        $statement = $this->dbConnection->prepare("DELETE FROM playlists WHERE id = ? AND user_id = ?");
        $statement->bind_param("ii", $playlist_id, $user_id);
        $statement->execute();
        return $statement->affected_rows > 0;
    }
} 