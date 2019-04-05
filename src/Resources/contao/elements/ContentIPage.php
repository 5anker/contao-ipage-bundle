<?php

namespace Anker\IPageBundle;

use Contao\NewsModel;
use Contao\ContentElement;
use Detection\MobileDetect;

class ContentIPage extends ContentElement
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'ce_ipage';

	/**
	 * Generate the module
	 */

	public function generate()
	{
		$ipage = IPageModel::findById($this->ipage);

		if (TL_MODE == 'BE') {
			$objTemplate = new \BackendTemplate('be_wildcard');
			$objTemplate->wildcard = $ipage->content;
			$objTemplate->title = $ipage->title;

			return $objTemplate->parse();
		}

		return parent::generate();
	}

	protected function compile()
	{
		$ipage = IPageModel::findById($this->ipage);

		$this->content = \StringUtil::toHtml5($ipage->content);
		$this->teaser = \StringUtil::toHtml5($ipage->teaser);

		// Add the static files URL to images
		if ($staticUrl = \System::getContainer()->get('contao.assets.files_context')->getStaticUrl()) {
			$path = \Config::get('uploadPath') . '/';

			$this->content = str_replace(' src="' . $path, ' src="' . $staticUrl . $path, $this->content);
			$this->teaser = str_replace(' src="' . $path, ' src="' . $staticUrl . $path, $this->teaser);
		}

		$this->Template->title = $ipage->title;
		$this->Template->headline = $ipage->headline;
		$this->Template->content = \StringUtil::encodeEmail($this->content);
		$this->Template->teaser = \StringUtil::encodeEmail($this->teaser);
		$this->Template->formular = $ipage->formular;
		$this->Template->query = $ipage->bquery;
		$this->Template->slider = $ipage->slider;
		$this->Template->detect = new MobileDetect();

		$objModel = \FilesModel::findByUuid($ipage->singleSRC);

		$this->Template->src = ($objModel !== null && is_file(TL_ROOT . '/' . $objModel->path)) ? $objModel->path : null;

		$elements = '';
		$slides = [];
		$infos = [];
		$cruises = [];
		$features = [];
		$news = [];

		// Output

		$objElement = \ContentModel::findPublishedByPidAndTable($this->ipage, 'tl_ipage');

		if ($objElement !== null) {
			while ($objElement->next()) {
				$elements .= $this->getContentElement($objElement->current());
			}
		}

		// Slides

		$objElement = IPageSlideModel::findByPid($this->ipage, ['order' => 'sorting']);

		if ($objElement !== null) {
			while ($objElement->next()) {
				$objModel = \FilesModel::findByUuid($objElement->singleSRC);

				if ($objModel !== null && is_file(TL_ROOT . '/' . $objModel->path)) {
					$slides[] = (object)[
						'type' => $objElement->type,
						'title' => $objElement->title,
						'href' => \Controller::replaceInsertTags($objElement->href),
						'src' => $objModel->path,
					];
				}
			}
		}

		// infos

		$objElement = IPageInfoModel::findByPid($this->ipage, ['order' => 'sorting']);

		if ($objElement !== null) {
			while ($objElement->next()) {
				$content = \StringUtil::toHtml5($objElement->content);

				// Add the static files URL to images
				if ($staticUrl = \System::getContainer()->get('contao.assets.files_context')->getStaticUrl()) {
					$path = \Config::get('uploadPath') . '/';

					$content = str_replace(' src="' . $path, ' src="' . $staticUrl . $path, $content);
				}

				$content = \StringUtil::encodeEmail($content);

				$infos[] = (object)[
					'title' => $objElement->title,
					'content' => $content
				];
			}
		}

		// features

		$objElement = IPageFeatureModel::findByPid($this->ipage, ['order' => 'sorting']);

		if ($objElement !== null) {
			while ($objElement->next()) {
				$content = \StringUtil::toHtml5($objElement->content);

				// Add the static files URL to images
				if ($staticUrl = \System::getContainer()->get('contao.assets.files_context')->getStaticUrl()) {
					$path = \Config::get('uploadPath') . '/';

					$content = str_replace(' src="' . $path, ' src="' . $staticUrl . $path, $content);
				}

				$content = \StringUtil::encodeEmail($content);

				$objModel = \FilesModel::findByUuid($objElement->icon);

				if ($objModel !== null && is_file(TL_ROOT . '/' . $objModel->path)) {
					$features[] = (object)[
						'title' => $objElement->title,
						'icon' => $objModel->path,
						'content' => $content
					];
				}
			}
		}

		// news

		$objElement = NewsModel::findMultipleByIds(unserialize($ipage->news));

		if ($objElement !== null) {
			while ($objElement->next()) {
				$content = \StringUtil::toHtml5($objElement->teaser);

				// Add the static files URL to images
				if ($staticUrl = \System::getContainer()->get('contao.assets.files_context')->getStaticUrl()) {
					$path = \Config::get('uploadPath') . '/';

					$content = str_replace(' src="' . $path, ' src="' . $staticUrl . $path, $content);
				}

				$content = \StringUtil::encodeEmail($content);

				$objModel = \FilesModel::findByUuid($objElement->singleSRC);

				if ($objModel !== null && is_file(TL_ROOT . '/' . $objModel->path)) {
					$src = $objModel->path;
				}

				$news[] = (object)[
					'title' => $objElement->headline,
					'src' => $src ?? null,
					'teaser' => $content,
					'datetime' => $objElement->datetime,
					'href' => \Controller::replaceInsertTags('{{news_url::'.$objElement->id.'}}'),
				];
			}
		}

		// cruises

		$objElement = NewsModel::findMultipleByIds(unserialize($ipage->cruises));

		if ($objElement !== null) {
			while ($objElement->next()) {
				$content = \StringUtil::toHtml5($objElement->teaser);

				// Add the static files URL to images
				if ($staticUrl = \System::getContainer()->get('contao.assets.files_context')->getStaticUrl()) {
					$path = \Config::get('uploadPath') . '/';

					$content = str_replace(' src="' . $path, ' src="' . $staticUrl . $path, $content);
				}

				$content = \StringUtil::encodeEmail($content);

				$objModel = \FilesModel::findByUuid($objElement->singleSRC);

				if ($objModel !== null && is_file(TL_ROOT . '/' . $objModel->path)) {
					$src = $objModel->path;
				}

				$cruises[] = (object)[
					'title' => $objElement->headline,
					'src' => $src ?? null,
					'teaser' => $content,
					'datetime' => $objElement->datetime,
					'href' => \Controller::replaceInsertTags('{{news_url::'.$objElement->id.'}}'),
				];
			}
		}

		$this->Template->cruises = $cruises;
		$this->Template->news = $news;
		$this->Template->slides = $slides;
		$this->Template->infos = $infos;
		$this->Template->features = $features;
		$this->Template->elements = $elements;
	}
}

class_alias(ContentIPage::class, 'ContentIPage');
