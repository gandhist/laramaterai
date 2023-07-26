<?php

namespace Gandhist\Ematerai;

class Document extends RemoteApi
{

    /**
     * get detail of document by document id
     * @param string @document_id
     * @return string response API
     */
    public function detail(string $document_id)
    {
        return $this->get("/documents/$document_id", []);
    }

    /**
     * get detail of document by document id
     * @param string @document_id
     * @return void response PDF
     */
    public function download(string $document_id)
    {
        return $this->get("/documents/$document_id/download", []);
    }
}
