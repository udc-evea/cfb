<?php

class NivelEstudios extends Eloquent {
	const NIVEL_SEC_COMPLETO = 4;
        protected $guarded = array();
        protected $table = 'repo_nivel_estudios';

	public static $rules = array();
}
