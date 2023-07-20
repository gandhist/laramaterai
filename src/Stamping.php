<?php

namespace Gandhist\Ematerai;

class Stamping extends RemoteApi{

    /**
     * Function to stamp a e Materai to document
     * @param string $base64
     * @param string $filename
     * @param array $annotation
     * @param string $callback
     * @return string
     */
    public function stamp(string $base64, string $filename, array $annotation, string $callback){
        return $this->post("/documents/stamp", [
            'doc' => $base64,
            'filename' => $filename,
            'annotations' => $annotation,
            'callback' => $callback,
        ]);
    }

    /** 
     * Function to check API version
     * @return string
     */
    public function version(){
        return $this->get('/version', []);
    }

}