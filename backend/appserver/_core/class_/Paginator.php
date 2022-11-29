<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Paginator
 *
 * @author USER
 */
class Paginator {

    private $count_rows = 0;
    private $count_pags = 0;
    private $actual_pag = 1;
    private $renderPaginator = null;
    public static $COUNT_BY_PAG = 10;

    function __construct($count_rows, $pag = 1, $arg = []) {
        if ($pag < 1) {
            $pag = 1;
        }
        $this->count_rows = $count_rows;
        $this->count_pags = $this->match();
        $this->setActual_pag($pag);
        $this->renderPaginator();
    }

    function getCount_rows() {
        return $this->count_rows;
    }

    function getCount_pags() {
        return $this->count_pags;
    }

    function getActual_pag() {
        return $this->actual_pag;
    }

    function setActual_pag($pag) {
        $pag = intval($pag);
        if ($pag >= 1 && $pag <= $this->count_pags) {
            $this->actual_pag = $pag;
        }
        return $this->actual_pag;
    }

    function setNextPag() {
        $next = $this->actual_pag;
        if (($this->actual_pag + 1) >= 1 && ($this->actual_pag + 1) <= $this->count_pags) {
            $next = ($this->actual_pag + 1);
        }
        return $next;
    }

    function setPrevPag() {
        $prev = $this->actual_pag;
        if (($this->actual_pag - 1) >= 1 && ($this->actual_pag - 1) <= $this->count_pags) {
            $prev = ($this->actual_pag - 1);
        }
        return $prev;
    }

    function renderPaginator() {
        $html = "<ul class='pagination'>";
        $disabled = "";
        if ($this->count_pags <= 1 || $this->actual_pag === 1) {
            $disabled = "disabled";
        }
        $html .= "<li class='page-item {$disabled}'><a class='page-link' href='#" . $this->setPrevPag() . "'>Previous</a></li>";
        for ($i = 1; $i <= $this->count_pags; $i++) {
            $active = "";
            if ($this->actual_pag === $i) {
                $active = 'active';
            }
            $html .= "<li class='page-item {$active}'><a class = 'page-link' href = '#{$i}'>{$i}</a></li>";
        }
        $disabled = "";
        //echo "-{$this->actual_pag}-{$this->count_pags}/";
        if ($this->count_pags <= 1 || $this->actual_pag >= $this->count_pags) {
            $disabled = "disabled";
        }
        $html .= "<li class='page-item {$disabled}'><a class='page-link' href='#" . $this->setNextPag() . "'>Next</a></li>";
        $html .= "</ul>";
        $this->renderPaginator = $html;
        return $html;
    }

    private function match() {
        $cantidad = 0;
        if ($this->count_rows === 0) {
            return 0;
        } else if ($this->count_rows < self::$COUNT_BY_PAG) {
            return 1;
        } else {
            return ceil($this->count_rows / self::$COUNT_BY_PAG);
        }
    }

    public function getInicioLimit() {
        $init = ($this->actual_pag - 1) * self::$COUNT_BY_PAG;
        return $init;
    }

}
