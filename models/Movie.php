<?php

class Movie
{

    public $id;
    public $title;
    public $description;
    public $image;
    public $trailer;
    public $category;
    public $lenght;
    public $users_id;

    public function imageGenerateName($extension = "jpg")
    {
        return bin2hex(random_bytes(60)) . "." . $extension;
    }
}

interface MovieDAOInterface {

    public function buildMovie($data);
    public function findAll();
    public function getLatestMovies();
    public function getMoviesByCategory($category);
    public function getMoviesById($id);
    public function findById($id);
    public function findByTitle($title);
    public function create($movie);
    public function update($movie);
    public function destroy($id);

}