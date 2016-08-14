<?php
namespace App\Models\Article;

/**
 * Class Category
 * @package App\Models\Article
 */
final class Category
{
    public function __construct(){}

    public function getList()
    {
        return [

            'Web Development',
            'PHP Development',
            'Javascript Tutorial',
            'Security Systems',
            'Drone Mapping'

        ];
    }
}