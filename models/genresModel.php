<?php

namespace Models;

include_once 'baseModel.php';

class GenresModel extends BaseModel
{
    public function __construct($args = array())
    {
        $args['table'] = 'genres';
        parent::__construct($args);
    }

    public function getGenres()
    {
        $statement = $this->dbConnection->prepare("SELECT g.id, g.name, (SELECT COUNT(*) FROM genres_types where genres_types.genre_id=g.id) as genre_types_count FROM genres g");
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

    public function getGenreTypesByGenreType($genre_id)
    {
        $statement = $this->dbConnection->prepare("SELECT * FROM genres_types WHERE genres_types.genre_id = ?");
        $statement->bind_param('i', $genre_id);
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

    public function getGenreTypesGroupByGenreId()
    {
        $statement = $this->dbConnection->prepare("SELECT * FROM genres_types ORDER BY genre_id, name");
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