<?php

class Uospagination extends \Fuel\Core\Pagination
{

	public function last($marker = null)
	{
		$html = '';

		$marker === null and $marker = $this->template['last-marker'];

		if ($this->config['show_last'])
		{
			$marker = str_replace('{page}', $this->config['total_pages'], $marker);

			if ($this->config['total_pages'] > 1 and $this->config['calculated_page'] != $this->config['total_pages'])
			{
				$html = str_replace(
					'{link}', str_replace(array('{uri}', '{page}'), array($this->_make_link($this->config['total_pages']), $marker), $this->template['last-link']), $this->template['last']
				);
				$this->raw_results['last'] = array('uri' => $this->_make_link($this->config['total_pages']), 'title' => $marker, 'type' => 'last');
			}
			else
			{
				$html = str_replace(
					'{link}', str_replace(array('{uri}', '{page}'), array('#', $marker), $this->template['last-inactive-link']), $this->template['last-inactive']
				);
				$this->raw_results['last'] = array('uri' => '#', 'title' => $marker, 'type' => 'last-inactive');
			}
		}

		return $html;
	}

}
