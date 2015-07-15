<?php namespace Arcanedev\Head\Entities;

use Arcanedev\Head\Contracts\Renderable;
use Arcanedev\Head\Exceptions\InvalidGoogleAnalyticsIdException;

/**
 * Class Analytics
 * @package Arcanedev\Head\Entities
 */
class Analytics implements Renderable
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @var string
     */
    protected $id      = '';

    /**
     * @var bool
     */
    protected $enabled = false;

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
     * Get enable status
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set enabled
     *
     * @param  bool $enabled
     *
     * @return self
     */
    private function setEnabled($enabled)
    {
        $this->enabled = $enabled;

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
     * Enable the google analytics
     *
     * @return self
     */
    public function enable()
    {
        return $this->setEnabled(true);
    }

    /**
     * Disable the google analytics
     *
     * @return self
     */
    public function disable()
    {
        return $this->setEnabled(false);
    }

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
        return $this->enabled && ! empty($this->id);
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
