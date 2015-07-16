<?php namespace Arcanedev\Head\Entities\OpenGraph\Objects;

/**
 * Class Profile
 * @package Arcanedev\Head\Entities\OpenGraph\Objects
 */
class Profile extends AbstractObject
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
     * @param  string $firstName
     *
     * @return self
     */
    public function setFirstName($firstName)
    {
        if ($this->checkName($firstName)) {
            $this->first_name = $firstName;
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
     * @param  string $lastName
     *
     * @return self
     */
    public function setLastName($lastName)
    {
        if ($this->checkName($lastName)) {
            $this->last_name = $lastName;
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
     * @param  string $username
     *
     * @return self
     */
    public function setUsername($username)
    {
        if ($this->checkName($username)) {
            $this->username = $username;
        }

        return $this;
    }

    /**
     * The person's gender.
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
     * @param  string $gender male|female
     *
     * @return self
     */
    public function setGender($gender)
    {
        if ($this->checkGender($gender)) {
            $this->gender = $gender;
        }

        return $this;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check name
     *
     * @param  string $name
     *
     * @return bool
     */
    private function checkName($name)
    {
        return is_string($name) && ! empty($name);
    }

    /**
     * Check gender
     *
     * @param  string $gender
     *
     * @return bool
     */
    private function checkGender(&$gender)
    {
        return is_string($gender) && in_array($gender, ['male', 'female']);
    }
}
