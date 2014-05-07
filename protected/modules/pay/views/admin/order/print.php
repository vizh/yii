<?/** @var \application\components\utility\Paginator $paginator */?>
<div class="btn-toolbar"></div>
<div class="well">
  <?foreach ($paginator->getPages() as $page):?>
    <a href="<?=$page->url;?>" class="btn" target="_blank"><?=(($page->value-1) * $paginator->perPage)+1;?> &mdash; <?=$page->value * $paginator->perPage;?></a>
  <?endforeach;?>
</div>