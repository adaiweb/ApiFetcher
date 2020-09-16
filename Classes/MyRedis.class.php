<?php

/**
 * This file is part of YouTube API project.
 * © 2018 byvlad
 */

/**
 * Class MyRedis
 */
class MyRedis
{
    private $redis_expire;

    /**
     * @var Client $redis
     */
    private $redis;
    // private $redisS2;

    /**
     * MyRedis constructor.
     */
    public function __construct($host,$port,$password='',$redis_expire = 3600)
    {

        try {
            $this->redis = new Redis();
            $this->redis->connect($host, intval($port));
            
            if(!empty($password)) $this->redis->auth($password);

            $this->redis_expire = $redis_expire;

        } catch(RedisException $e) {
            die('Connect error: '.$e->getMessage());
        } 
    }
    public function ttl(string $key){
         return $this->redis->ttl($key);
    }

    /**
     * @param string $key
     * @return string
     */
    public function get(string $key)
    { 
        return $this->redis->get($key);
    }

    /**
     * @param string $key
     * @param $data
     * @param int $expire
     * @return mixed
     */
    public function set(string $key, $data, int $expire = null)
    {   
        // $expire = (is_null($expire)) ? $this->redis_expire : $expire;
        //  $this->redis->set($key, serialize($data));
        //  $this->redis->expire($encodedKey, $expire);
         $this->redis->set($key,$data,$expire);
         return '';
    }

     public function expire(string $key, int $expire = null){

        $expire = (is_null($expire)) ? $this->redis_expire : $expire;

         $encodedKey = $this->encodeKey($key);
         $redis      = $this->getServer($key);
        return $redis->expire($encodedKey, $expire);
    }


    /**
     * @param string $key
     * @return int
     */
    public function exists(string $key)
    {
        return $this->getServer($key)->exists($this->encodeKey($key));
    }

    /**
     * @param string $key
     * @return string
     */
    private function encodeKey(string $key): string
    {
        return strtolower(sha1($key));
    }
}