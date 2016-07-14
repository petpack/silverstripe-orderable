<?php
/**
 * A simple extension to add a sort field to an object.
 *
 * @package silverstripe-orderable
 */
class Orderable extends DataObjectDecorator {

	public function extraStatics() {
		return array('db' => array('Sort' => 'Int'));
	}

	public function augmentSQL(SQLQuery &$query) {
		if (!$query->orderby && !$query->delete) $query->orderby('"Sort"');
	}

	public function onBeforeWrite() {
		if (!$this->owner->Sort) {
			$max = DB::query(sprintf(
				'SELECT MAX("Sort") + 1 FROM "%s"', $this->ownerBaseClass
			));
			$this->owner->Sort = $max->value();
		}
	}

	public function updateCMSFields(FieldSet &$fields) {
		$fields->removeByName('Sort');
	}

	public function updateFrontEndFields(FieldSet &$fields) {
		$fields->removeByName('Sort');
	}

}