<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\VisitorInterest\Reports;

use Piwik\Piwik;
use Piwik\Plugin\ViewDataTable;
use Piwik\Plugins\CoreVisualizations\Visualizations\Cloud;
use Piwik\Plugins\CoreVisualizations\Visualizations\Graph;
use Piwik\Plugins\VisitorInterest\Columns\VisitDuration;

class GetNumberOfVisitsPerVisitDuration extends Base
{
    protected function init()
    {
        parent::init();
        $this->dimension     = new VisitDuration();
        $this->name          = Piwik::translate('VisitorInterest_WidgetLengths');
        $this->documentation = Piwik::translate('VisitorInterest_WidgetLengthsDocumentation')
                             . '<br />' . Piwik::translate('General_ChangeTagCloudView');
        $this->metrics       = array('nb_visits');
        $this->processedMetrics  = false;
        $this->constantRowsCount = true;
        $this->order = 15;
        $this->widgetTitle  = 'VisitorInterest_WidgetLengths';
    }

    public function getDefaultTypeViewDataTable()
    {
        return Cloud::ID;
    }

    public function configureView(ViewDataTable $view)
    {
        $view->requestConfig->filter_sort_column = 'label';
        $view->requestConfig->filter_sort_order  = 'asc';

        $view->config->addTranslation('label', $this->dimension->getName());
        $view->config->enable_sort = false;
        $view->config->show_exclude_low_population = false;
        $view->config->show_offset_information = false;
        $view->config->show_pagination_control = false;
        $view->config->show_limit_control      = false;
        $view->config->show_search             = false;
        $view->config->show_table_all_columns  = false;
        $view->config->columns_to_display      = array('label', 'nb_visits');

        if ($view->isViewDataTableId(Graph::ID)) {
            $view->config->show_series_picker = false;
            $view->config->selectable_columns = array();
            $view->config->max_graph_elements = 10;
        }
    }

}
