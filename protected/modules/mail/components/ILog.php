<?php

namespace mail\components;

interface ILog
{
    public function setError($error);

    public function save();
}