<?php

namespace WonderGame\EsUtility\HttpController\Admin;

use WonderGame\EsUtility\Common\Exception\HttpParamException;
use WonderGame\EsUtility\Common\Http\Code;

trait SysinfoTrait
{
	protected function __search()
	{
		$where = [];
		if (isset($this->get['status']) && $this->get['status'] !== '') {
			$where['status'] = $this->get['status'];
		}
		foreach (['varname', 'remark'] as $col) {
			if ( ! empty($this->get[$col])) {
				$where[$col] = ["%{$this->get[$col]}%", 'like'];
			}
		}
		return $where;
	}

    public function _add($return = false)
    {
        if ($this->isHttpPost()) {
            $this->__writeBefore();
            $count = $this->Model->where('varname', $this->post['varname'])->count();
            if ($count > 0) {
                throw new HttpParamException('varname exist: ' . $this->post['varname']);
            }
        }
        return parent::_add($return);
    }

    public function _edit($return = false)
    {
        if ($this->isHttpPost()) {
            $this->__writeBefore();
        }
        return parent::_edit($return);
    }

	protected function __writeBefore()
	{
		$post = $this->post;
		if (empty($post['varname']) || empty($post['value']) || ! isset($post['type'])) {
			throw new HttpParamException('Params invalid');
		}
	}
}
