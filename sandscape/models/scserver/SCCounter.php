<?php

/* SCCounter.php
 * 
 * This file is part of Sandscape.
 *
 * Sandscape is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * Sandscape is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Sandscape.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * Copyright (c) 2011, the Sandscape team and WTactics project.
 * http://wtactics.org
 */

/**
 * Represents counters, these can be added to cards or become part of a user.
 * 
 * @since 1.3, Soulharvester
 */
class SCCounter {

    private $id;
    private $name;
    private $value;
    private $initialValue;
    private $class;
    private $step;

    public function __construct($id, $name, $start = 0, $step = 1, $class = '') {
        $this->id = $id;
        $this->name = $name;
        $this->initialValue = $this->value = $start;
        $this->class = $class;
        $this->step = ($step ? $step : 1);
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = $value;
    }

    public function getClass() {
        return $this->class;
    }

    public function setClass($class) {
        $this->class = $class;
    }

    /**
     * Sets the counter's current value to the initial value.
     */
    public function reset() {
        $this->value = $this->initialValue;
    }

    /**
     * Increases the counter's value by the amount defined in <em>step</em>.
     */
    public function increase() {
        $this->value += $this->step;
    }

    /**
     * Decreases the counter's value by the amount defined in <em>step</em>.
     */
    public function decrease() {
        $this->value -= $this->step;
    }

    public function getJSONData() {
        return (object) array(
                    'id' => $this->id,
                    'name' => $this->name,
                    'value' => $this->value,
                    'color' => $this->class
        );
    }

}
