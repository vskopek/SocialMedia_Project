<?php

namespace app\Views;

class TemplateLoader
{
    const PAGE_HEADER = "PageHeader.tpl.php";
    const PAGE_FOOTER = "PageFooter.tpl.php";

    const HOME_PAGE = "Home.tpl.php";

    public function printOutput(array $data, string $page){
        global $templateData;
        $templateData = $data;

        require_once(self::PAGE_HEADER);

        require_once($page);

        require_once(self::PAGE_FOOTER);
    }
}