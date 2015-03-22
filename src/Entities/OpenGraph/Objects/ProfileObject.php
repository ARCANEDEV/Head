<?php namespace Arcanedev\Head\Entities\OpenGraph\Objects;

class ProfileObject extends AbstractObject
{
    /* ------------------------------------------------------------------------------------------------
     |  Constants
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Property prefix
     *
     * @var string
     */
    const PREFIX    = 'profile';

    /**
     * prefix namespace
     *
     * @var string
     */
    const NS        = 'http://ogp.me/ns/profile#';

    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * A person's given name
     *
     * @var string
     */
    protected $first_name;

    /**
     * A person's last name
     *
     * @var string
     */
    protected $last_name;

    /**
     * The profile's unique username
     *
     * @var string
     */
    protected $username;

    /**
     * Gender: male or female
     */
    protected $gender;

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the person's given name
     *
     * @return string given name
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set the person's given name
     *
     * @param string $first_name given name
     *
     * @return ProfileObject
     */
    public function setFirstName( $first_name )
    {
        if (is_string($first_name) and ! empty($first_name)) {
            $this->first_name = $first_name;
        }

        return $this;
    }

    /**
     * The person's family name
     *
     * @return string family name
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set the person's family name
     *
     * @param string $last_name family name
     *
     * @return ProfileObject
     */
    public function setLastName( $last_name )
    {
        if (is_string($last_name) and ! empty($last_name)) {
            $this->last_name = $last_name;
        }

        return $this;
    }

    /**
     * Person's username on your site
     *
     * @return string account username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the account username
     *
     * @param string $username username
     *
     * @return ProfileObject
     */
    public function setUsername( $username )
    {
        if (is_string($username) and ! empty($username)) {
            $this->username = $username;
        }

        return $this;
    }

    /**
     * The person's gender. male|female
     *
     * @return string male|female
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set the person's gender
     *
     * @param string $gender male|female
     *
     * @return $this
     */
    public function setGender($gender)
    {
        if (is_string($gender) and in_array($gender, ['male', 'female'])) {
            $this->gender = $gender;
        }

        return $this;
    }
}
