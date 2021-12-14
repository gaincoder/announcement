<?php

class pluginAnnouncement extends Plugin {

	public function init()
	{
		$this->dbFields = array(
			'start'=>'1970-01-01 00:00:00',
            'end' => '2042-12-31 23:59:59',
            'text' => '',
            'bordercolor' => 'darkblue',
            'borderwidth' => '1px'
		);
	}

	public function form()
	{
		global $L;

		$html  = '<div class="alert alert-primary" role="alert">';
		$html .= $this->description();
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label>'.$L->get('Start').'</label>';
		$html .= '<input name="start" type="text" value="'.$this->getValue('start').'">';
        $html .= '<label>'.$L->get('End').'</label>';
        $html .= '<input name="end" type="text" value="'.$this->getValue('end').'">';
        $html .= '<label>'.$L->get('Bordercolor').'</label>';
        $html .= '<input name="bordercolor" type="text" value="'.$this->getValue('bordercolor').'">';
        $html .= '<label>'.$L->get('Borderwidth').'</label>';
        $html .= '<input name="borderwidth" type="text" value="'.$this->getValue('borderwidth').'">';
        $html .= '<label>'.$L->get('Text').'</label>';
        $html .= '<textarea name="text">'.$this->getValue('text').'</textarea>';
        $html .= '<span class="tip">'.$L->get('HTML allowed').'</span>';
		$html .= '</div>';

		return $html;
	}

	public function siteHead()
    {
        $html = '';
        if ($this->shouldBeVisible()) {

            $html .= '<style media="screen">
                           .announcement{
                                position: relative;
                                border: '.$this->getValue('borderwidth').' '.$this->getValue('bordercolor').' solid;
                                margin: 2px;
                                padding: 2px;
                                text-align: center;
                           }
                       </style>';

            $html .= '<div class="announcement">' . $this->getValue('text',false) . '</div>';
        }
		return $html;
	}

    private function shouldBeVisible(){
        $filled = strlen($this->getValue('text')) > 0;
        $startPassed = time() >= strtotime($this->getValue('start'));
        $endNotPassed = time() <= strtotime($this->getValue('end'));
        return $filled && $startPassed && $endNotPassed;
    }
}