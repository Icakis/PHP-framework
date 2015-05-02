<?php
/**
 * Created by PhpStorm.
 * User: Icakis Nikus
 * Date: 2.5.2015 г.
 * Time: 14:13
 */

namespace Lib;


class notyMessage
{

    //    Types:

    //'alert'
    //'information'
    //'error'
    //'warning'
    //'notification'
    //'success'

    //  Positions:

    //'top'
    //'topCenter'
    //'topLeft'
    //'topRight'
    //'center'
    //'centerLeft'
    //'centerRight'
    //'bottom'
    //'bottomCenter'
    //'bottomLeft'
    //'bottomRight'

    protected $text;
    protected $type;
    protected $position;
    protected $time;
    protected $closeWith;
    protected $maxVisible;
    protected $modal;

    public function __construct($text, $type = 'alert', $position = 'topCenter', $time = 10000, $closeWith = '[\'click\']', $maxVisible = 10, $modal = false)
    {
        if (!$text) {
            throw new \Exception('Message text is required.');
        }

        $this->text = $text;
        $this->type = $type;
        $this->position = $position;
        $this->time = $time;
        $this->closeWith = $closeWith;
        $this->maxVisible = $maxVisible;
        $this->modal = $modal;
    }


        public function __toString()
        {
            return "
                <script>
                $(document).ready(function () {
                 var n =  noty({
                                    text        : '$this->text',
                                    type        : '$this->type',
                                    dismissQueue: true,
                                    maxVisible  : $this->maxVisible,
                                    timeout     : $this->time,
                                    layout      : '$this->position',
                                    theme       : 'defaultTheme'
                                })
                            });
                </script>";
        }
} 