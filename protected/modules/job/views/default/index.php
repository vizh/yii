<section id="section" role="main">
    <h2 class="b-header_large light">
      <div class="line"></div>
      <div class="container">
        <div class="title">
          <span class="backing runet">Runet</span>
          <span class="backing text">Работа</span>
        </div>
      </div>
    </h2>

    <div class="container">
      <?=\CHtml::form($this->createUrl('/job/default/index'), 'GET', array('class' => 'form-inline form-filter span12'));?>
        <?php $categories = $filter->getCategoryList();?>
        <?=\CHtml::activeDropDownList($filter, 'CategoryId', $categories, array('class' => 'span3 form-element_select form-filter_category', 'name' => 'Filter[CategoryId]'));?>
        <?foreach($categories as $id => $title):?>
          <?=\CHtml::activeDropDownList($filter, 'PositionId', $filter->getPositionList($id), array('class' => 'span3 form-element_select hide form-filter_position', 'data-category' => $id, 'name' => 'Filter[PositionId]', 'disabled' => 'disabled'));?>
        <?endforeach;?>
        <div class="dropdown form-filter_salary">
          От <a class="dropdown-toggle" href="#"><?=$filter->SalaryFrom;?></a><?=\CHtml::activeTextField($filter, 'SalaryFrom', array('class' => 'span1 hide', 'name' => 'Filter[SalaryFrom]'));?> Р
        </div>
        <div class="pull-right">
          <?=\CHtml::activeTextField($filter, 'Query', array('class' => 'span3', 'placeholder' => \Yii::t('app', 'Поиск'), 'name' => 'Filter[Query]'));?>
          <?=\CHtml::imageButton('/images/search-type-image-light.png', array('class' => 'form-element_image', 'width' => 20, 'height' => 19));?>
        </div>
      <?=\CHtml::endForm();?>
    </div>

    <div class="b-jobs">
      <div class="container">
        <div class="row">
          <?foreach (array_slice($jobs, 0, 4) as $job):?>
          <div class="job span3">
            <div class="details">
              <span class="label label-warning"><?=\Yii::app()->dateFormatter->format('dd MMMM', $job->CreateTime);?></span>
              <a href="<?=$this->createUrl('/company/view/index', array('companyId' => $job->CompanyId));?>" class="employer"><?=$job->Company->Name;?></a>
              <span class="fade-rtl"></span>
            </div>
            <header>
              <h4 class="title">
                <a href="<?=$this->createUrl('/job/view/index', array('jobId' => $job->Id));?>"><?=$job->Title;?></a>
              </h4>
            </header>
            <article>
              <p><?=$job->getPreview();?></p>
              <a href="#"><?=\Yii::t('app', 'Ответить на вакансию');?></a>
            </article>
            <footer class="salary">
              <?=$this->renderPartial('job-salary', array('job' => $job));?>
            </footer>
            <div class="category">
              <a href="<?=$this->createUrl('/job/default/index', array('Filter[CategoryId]' => $job->CategoryId));?>"><?=$job->Category->Title;?></a>
            </div>
          </div>
          <?endforeach;?>
        </div>
      </div>
      
      <?if ($jobUp !== null):?>
      <div class="job_promo">
        <div class="bg"></div>
        <div class="container">
          <div class="job">
            <div class="details">
              <span class="label label-warning"><?=\Yii::app()->dateFormatter->format('dd MMMM', $jobUp->Job->CreateTime);?></span>
              <div class="employer-row">
                <a href="<?=$this->createUrl('/company/view/index', array('companyId' => $jobUp->Job->CompanyId));?>" class="employer">
                  <?=\CHtml::image($jobUp->Job->Company->getLogo(), $jobUp->Job->Company->Name, array('width' => 20, 'height' => 30));?>
                </a>
              </div>
            </div>
            <header>
              <h2 class="title">
                <a href="<?=$this->createUrl('/job/view/index', array('jobId' => $jobUp->Job->Id));?>"><?=$jobUp->Job->Title;?></a>
              </h2>
            </header>
            <article>
              <p><?=$jobUp->Job->getPreview();?></p>
              <a href="#"><?=\Yii::t('app', 'Ответить на вакансию');?></a>
            </article>
            <div class="row">
              <div class="span4 offset4">
                <footer class="salary">
                  <?=$this->renderPartial('job-salary', array('job' => $jobUp->Job));?>
                </footer>
              </div>
            </div>
            <div class="category">
              <a href="<?=$this->createUrl('/job/default/index', array('Filter[CategoryId]' => $jobUp->Job->CategoryId));?>"><?=$jobUp->Job->Category->Title;?></a>
            </div>
          </div>
        </div>
      </div>
      <?endif;?>

      
      <div class="container">
        <div class="row">
          <?foreach (array_slice($jobs, 4, sizeof($jobs)-4) as $job):?>
          <div class="job span3">
            <div class="details">
              <span class="label label-warning"><?=\Yii::app()->dateFormatter->format('dd MMMM', $job->CreateTime);?></span>
              <a href="<?=$this->createUrl('/company/view/index', array('companyId' => $job->CompanyId));?>" class="employer"><?=$job->Company->Name;?></a>
              <span class="fade-rtl"></span>
            </div>
            <header>
              <h4 class="title">
                <a href="<?=$this->createUrl('/job/view/index', array('jobId' => $job->Id));?>"><?=$job->Title;?></a>
              </h4>
            </header>
            <article>
              <p><?=$job->getPreview();?></p>
              <a href="#"><?=\Yii::t('app', 'Ответить на вакансию');?></a>
            </article>
            <footer class="salary">
              <?=$this->renderPartial('job-salary', array('job' => $job));?>
            </footer>
            <div class="category">
              <a href="<?=$this->createUrl('/job/default/index', array('Filter[CategoryId]' => $job->CategoryId));?>"><?=$job->Category->Title;?></a>
            </div>
          </div>
          <?endforeach;?>
        </div>
      </div>
    </div>

    <?$this->widget('application\widgets\Paginator', array(
      'count' => $allJobCount,
      'perPage' => \Yii::app()->params['JobPerPage']
    ));?>
  </section>
