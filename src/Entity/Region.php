<?php

namespace App\Entity;

enum Region:string
{
    case USA = "en_US";
    case Czech = "cs_CZ";
    case Poland = "pl_PL";
    case Russia = "ru_RU";
}