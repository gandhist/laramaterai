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

    /**
     * Function to re-stamp document by document id
     * @param string $dokumen_id
     */
    public function restamp(string $document_id){
        return $this->post("/documents/$document_id/resend", []);
    }

}