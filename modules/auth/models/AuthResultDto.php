<?php

class AuthResultDto {
    public int $user_id;

    public function __construct(int $user_id)
    {
        $this->user_id = $user_id;
    }
}