<?php

namespace Core\Auth;

enum Role: int
{
	case ADMIN = 1;
	case PETUGAS = 2;
	case SISWA = 3;
}