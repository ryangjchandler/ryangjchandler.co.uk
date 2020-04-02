<?php

function carbon($time = null)
{
    return Carbon\Carbon::parse($time);
}

function now()
{
    return Carbon\Carbon::now();
}