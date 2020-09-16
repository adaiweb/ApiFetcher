<?php

class Functions {
	/**
     * __call
     *
     * @param string	$name
     * @param string OR array	$key
     * @return string OR array
     */
    public function __call($name, $key) {
     	require_once(ROOT . '/Functions/function.' . $name . '.php');
     	return call_user_func_array($name, $key);
    }
}
?>