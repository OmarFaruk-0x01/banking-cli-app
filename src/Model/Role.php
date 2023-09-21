<?php

namespace BankingApp\Model;

enum Role: string
{
    case ADMIN = "Admin";
    case CUSTOMER = "Customer";
    case GUEST = "GUEST";
}
