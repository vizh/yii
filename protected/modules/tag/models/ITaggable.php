<?php
namespace tag\models;

interface ITaggable
{
    public function byTagId($id, $useAnd = true);
}
