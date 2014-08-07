<?php

class Template extends Eloquent{
    protected $table = 'templates';

    protected $fillable = ['title','display_title','body'];
}
