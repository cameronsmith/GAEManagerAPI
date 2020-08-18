<?php namespace CameronSmith\GAEManagerAPI\Test\Stubs;

class PHPStream
{
    /**
     * @var int
     */
    protected $int_index = 0;

    /**
     * @var int|null
     */
    protected $int_length = null;

    /**
     * @var string
     */
    protected $str_data = '';

    public $context;

    /**
     * PhpStream constructor.
     */
    function __construct()
    {
        if (file_exists($this->buffer_filename())) {
            $this->str_data = file_get_contents($this->buffer_filename());
        }

        $this->int_index = 0;
        $this->int_length = strlen($this->str_data);
    }

    /**
     * Get buffer filename.
     *
     * @return string
     */
    protected function buffer_filename()
    {
        return sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'php_input.txt';
    }

    /**
     * Seek stream
     *
     * @param $offset
     * @param $whence
     * @return bool
     */
    public function stream_seek($offset, $whence) {
        $this->int_index = 0;

        return true;
    }

    /**
     * Stream tell.
     *
     * @return int
     */
    public function stream_tell() {
        return $this->int_index;
    }

    /**
     * Open stream.
     *
     * @param $path
     * @param $mode
     * @param $options
     * @param $opened_path
     * @return bool
     */
    public function stream_open($path, $mode, $options, &$opened_path)
    {
        return true;
    }

    /**
     * Close stream
     */
    public function stream_close()
    {
    }

    /**
     * Get stream stat.
     *
     * @return array
     */
    public function stream_stat()
    {
        return [];
    }

    /**
     * Flush stream.
     *
     * @return bool
     */
    public function stream_flush()
    {
        return true;
    }

    /**
     * Read stream.
     *
     * @param $count
     * @return bool|string
     */
    public function stream_read($count)
    {
        if (is_null($this->int_length) === true) {
            $this->int_length = strlen($this->str_data);
        }

        $int_length = min($count, $this->int_length - $this->int_index);
        $str_data = substr($this->str_data, $this->int_index);
        $this->int_index = $this->int_index + $int_length;

        return $str_data;
    }

    /**
     * EOF stream.
     *
     * @return bool
     */
    public function stream_eof()
    {
        return ($this->int_index >= $this->int_length ? true : false);
    }

    /**
     * Write stream.
     *
     * @param $data
     * @return bool|int
     */
    public function stream_write($data)
    {
        return file_put_contents($this->buffer_filename(), $data);
    }

    /**
     * Unlink
     */
    public function unlink()
    {
        if (file_exists($this->buffer_filename())) {
            unlink($this->buffer_filename());
        }

        $this->str_data = '';
        $this->int_index = 0;
        $this->int_length = 0;
    }
}