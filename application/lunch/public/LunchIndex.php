<?php
AutoLoader::Import('comment.source.*');

class LunchIndex extends GeneralCommand
{
  const CurrentLunch = 5;

  private function getLunchs()
  {
    $lunchs = array(
      1 => array(
        'id' => 1,
        'title' => 'Бизнес-Ланч c Денисом Тереховым',
        'menu' => array(
          'СМИ о чём-то большем с Денисом Тереховым, агентство "Социальные Сети"',
          'Илья Дронов, руководитель LiveJournal',
          '"Премия Рунета" и итоги 2011 года',
          'Авинаш Кошик, digital marketing evangelist компании Google, об интернет-маркетинге и его измерении'
        ),
        'youtube' => '<iframe width="672" height="372" src="http://www.youtube.com/embed/vqauzCXHuok?rel=0" frameborder="0" allowfullscreen></iframe>',
        'youtube_id' => 'vqauzCXHuok',
        'date' => '2011-11-25'
      ),
      2 => array(
        'id' => 2,
        'title' => 'Бизнес-Ланч c Фёдором Вириным',
        'menu' => array(
          'СМИ о чём-то большем с Фёдором Вириным, партнёр Data Insight и "НЛО-Маркетинг"',
          'Мобильная онлайн-торговля в России и мире',
          'Максим Захир, директор по электронной коммерции торговой сети "М Видео"'
        ),
        'youtube' => '<iframe width="672" height="372" src="http://www.youtube.com/embed/4gxWQs0RbAg?rel=0" frameborder="0" allowfullscreen></iframe>',
        'youtube_id' => '4gxWQs0RbAg',
        'date' => '2011-12-02'
      ),
      3 => array(
        'id' => 3,
        'title' => '"Бизнес-ланч" с Любовью Симоновой (Almaz Capital)',
        'menu' => array(
          'Главное за неделю с Любовью Симоновой (Almaz Capital)',
          'TechCrunch в Москве',
          'Стартапы и инвесторы в рунете с Германом Клименко (LiveInternet)'
        ),
        'youtube' => '<iframe width="672" height="372" src="http://www.youtube.com/embed/4zP2J0hVerU?rel=0" frameborder="0" allowfullscreen></iframe>',
        'youtube_id' => '4zP2J0hVerU',
        'date' => '2011-12-09'
      ),
      4 => array(
        'id' => 4,
        'title' => '"Бизнес-ланч" с Леонидом Бугаевым (Nordic)',
        'menu' => array(
          'Главное за неделю с Леонидом Бугаевым (Nordic)',
          'Интернет-реклама сегодня с Кириллом Готовцевым (Maniaco)'
        ),
        'youtube' => '<iframe width="672" height="372" src="http://www.youtube.com/embed/o-fHdOFf9bg?rel=0" frameborder="0" allowfullscreen></iframe>',
        'youtube_id' => 'o-fHdOFf9bg',
        'date' => '2011-12-16'
      ),
      5 => array(
        'id' => 5,
        'title' => '"Бизнес-ланч" с Натальей Лосевой (РИА Новости)',
        'menu' => array(
          'Главное за неделю с Натальей Лосевой (РИА Новости)',
          'Российские медиа и выборы Президента РФ: никакой политики, только бизнес',
          'Эксперт на проводе'
        ),
        'youtube' => '<iframe width="672" height="372" src="http://www.youtube.com/embed/4TMf4YA4ILA?rel=0" frameborder="0" allowfullscreen></iframe>',
        'youtube_id' => '4TMf4YA4ILA',
        'date' => '2012-02-10'
      )
    );

    return $lunchs;
  }

  private function getLunch($lunchId)
  {
    $lunchs = $this->getLunchs();
    return isset($lunchs[$lunchId]) ? $lunchs[$lunchId] : null;
  }



  /**
   * Основные действия комманды
   * @param int $lunchId
   * @return void
   */
  protected function doExecute($lunchId = 0)
  {
    $lunchId = intval($lunchId);
    $lunchId = !empty($lunchId)? $lunchId : self::CurrentLunch;
    $lunch = $this->getLunch($lunchId);
    if ($lunch === null)
    {
      Lib::Redirect(RouteRegistry::GetUrl('lunch', '', 'index'));
    }
    /*$lunchId = !empty($lunchId)? $lunchId : self::CurrentLunch;
    if ($lunchId != self::CurrentLunch)
    {
      $this->view->SetTemplate('lunch-'.$lunchId);
    }*/
    $titles = Registry::GetWord('titles');
    $this->SetTitle($titles['plain'] . ' ' . $lunch['title']);

    // fill meta
    $view = new View();
    $view->SetTemplate('meta');
    $view->Url = 'http://' . $_SERVER['HTTP_HOST'] . '/lunch/' . $lunchId . '/';
    $view->Title = $this->view->Title;
    $view->Quote = '';
    $view->Image = 'http://' . $_SERVER['HTTP_HOST'] . '/images/lunch/logo-50.png';
    $this->view->MetaTags = $view;
    $this->view->Url = $view->Url;
    $this->view->Lunch = $lunch;
    $this->view->CurrentLunch = $this->getLunch(self::CurrentLunch);
    $this->view->Lunchs = $this->getLunchs();

    $this->view->Comments = new CommentViewer($lunchId, CommentModel::ObjectLunch);

    echo $this->view;
  }
}
