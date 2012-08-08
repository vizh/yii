<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nikitin
 * Date: 10.02.12
 * Time: 16:30
 * To change this template use File | Settings | File Templates.
 */
class EFeedItemYandex extends EFeedItemRSS2
{
  protected $CDATAEncoded = array();

  /**
   * (non-PHPdoc)
   * @see EFeedItemAbstract::getNode()
   */
  public function getNode(){


    $node = CHtml::openTag('item').PHP_EOL;

    foreach( $this->tags as $tag ){
      $node .= $this->getElement($tag);
    }

    $node .= CHtml::closeTag('item');

    return $node.PHP_EOL;
  }
  /**
   *
   * @returns well formatted xml element
   * @param EFeedTag $tag
   */
  private function getElement( EFeedTag $tag ){

    $element = '';

    if(in_array($tag->name,$this->CDATAEncoded))
    {
      $element .= CHtml::openTag($tag->name,$tag->attributes);
      $element .= '<![CDATA[';

    }else
    {
      $element .= CHtml::openTag($tag->name,$tag->attributes);
    }
    $element .= PHP_EOL;

    if(is_array($tag->content))
    {
      foreach ($tag->content as $tag => $content)
      {
        $tmpTag = new EFeedTag($tag, $content);

        $element .= $this->getElement( $tmpTag );
      }
    }
    else
    {
      $element .= (in_array($tag->name, $this->CDATAEncoded))? $tag->content : str_replace('\'', '&apos;', htmlspecialchars($tag->content, ENT_COMPAT));
    }

    $element .= (in_array($tag->name, $this->CDATAEncoded))? PHP_EOL.']]>':"";

    $element .= CHtml::closeTag($tag->name).PHP_EOL;

    return $element;
  }
}
