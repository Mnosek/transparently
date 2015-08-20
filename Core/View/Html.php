<?php

namespace Core\View;


/**
 * Default HTML view model
 * @author <mmnosek@gmail.com>
 */
class Html extends BaseView
{
    CONST DEFAULT_HEADER = 'header.php' ;
    CONST DEFAULT_FOOTER = 'footer.php' ;


    /**
     * Rendered template path
     * @var string
     */
    private $_templatePath;


    /**
     * View constructor
     * @param string $templatePath path to template file
     */
    public function __construct($templatePath) {
        $this->_templatePath = $templatePath;
    }


    /**
     * Renders template
     * @param  boolean $isBlank if true doesn't attach default header and footer
     * @return string rendered content
     */
    public function render($isBlank = false)
    {
        extract($this->_data);
        ob_start();

        if (!$isBlank) {
            include MODULE_PATH . 'Application' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . 'element' . DIRECTORY_SEPARATOR . self::DEFAULT_HEADER;
        }

        include $this->_templatePath;

        if (!$isBlank) {
            include MODULE_PATH . 'Application' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . 'element' . DIRECTORY_SEPARATOR . self::DEFAULT_FOOTER;
        }
        return ob_get_clean();
    }
}