<?php

namespace Core\View;


/**
 * View abstract class
 * @author Michał Nosek <mmnosek@gmail.com>
 */
abstract class BaseView
{
    protected $_data;

    /**
     * Should render view depending on final class
     */
    abstract function render($isBlank = false);


    /**
     * Binds data to view
     * @param  mixed[] $data
     */
    public function bindData($data)
    {
        $this->_data = $data;
    }
}