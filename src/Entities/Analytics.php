<?php namespace Arcanedev\Head\Entities;

use Arcanedev\Head\Contracts\Renderable;
use Arcanedev\Head\Exceptions\InvalidGoogleAnalyticsIdException;
use Arcanedev\Head\Traits\EnablerTrait;

/**
 * Class Analytics
 * @package Arcanedev\Head\Entities
 */
class Analytics implements Renderable
{
    /* ------------------------------------------------------------------------------------------------
     |  Traits
     | ------------------------------------------------------------------------------------------------
     */
    use EnablerTrait;

    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @var string
     */
    protected $id      = '';

    /**
     * @var string
     */
    protected $script  = '';

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    public function __construct($id = '')
    {
        $this->setId($id);
        $this->enable();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Set the Google Analytics ID
     *
     * @param  string $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->checkId($id);

        $this->id = $id;

        return $this;
    }

    /**
     * Set config
     *
     * @param  array $config
     *
     * @return self
     */
    public function setConfig(array $config = [])
    {
        if (isset($config['active'])) {
            $this->setEnabled((bool) $config['active']);
        }

        if (isset($config['id'])) {
            $this->setId($config['id']);
        }

        // TODO: Add a setScript for a custom google analytics script

        return $this;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Render Google analytics script
     *
     * @return string
     */
    public function render()
    {
        if ( ! $this->isRenderable()) {
            return '';
        }

        return $this->getScript();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check Google Analytics ID
     *
     * @param  string $id
     *
     * @throws InvalidGoogleAnalyticsIdException
     */
    private function checkId(&$id)
    {
        $id = strtoupper(trim($id));

        if ( ! empty($id) && ! preg_match('/UA-\d+-\d{1,2}$/', $id)) {
            throw new InvalidGoogleAnalyticsIdException(
                "The google analytics Id [$id] is invalid, must be like UA-XXXXXX-X."
            );
        }
    }

    /**
     * Check if Google Analytics is renderable
     *
     * @return bool
     */
    public function isRenderable()
    {
        return $this->isEnabled() && ! empty($this->id);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get Google Analytics script
     *
     * @return string
     */
    private function getScript()
    {
        return <<< HEAD
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', '$this->id', 'auto');
  ga('send', 'pageview');
</script>
HEAD;
    }
}
