<?php

namespace App;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Ods;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Export
{
    const EXTENSION_XLSX = 'xlsx';
    const EXTENSION_ODS = 'ods';
    const EXTENSION_PDF = 'pdf';

    protected $extensions = [self::EXTENSION_XLSX, self::EXTENSION_ODS, self::EXTENSION_PDF];
    protected $spreadsheet;
    protected $writer;
    protected $extension;
    protected $name;

    /**
     * Export constructor.
     * @param Spreadsheet $spreadsheet
     * @param string $name
     * @param string $extension
     */
    public function __construct($spreadsheet, $name, $extension)
    {
        $this->spreadsheet = $spreadsheet;
        $this->name = $name;
        $this->extension = $extension;
    }

    public function save()
    {
        $this->rules();
        $this->writer->save($this->getFilename());
    }

    public function download()
    {
        // Check different rules before starting the process
        $this->rules();

        $this->applyHeaders();
        dd('Passe 7');

        // Set the good writer
        $this->setWriter();
//        $this->writer = IOFactory::createWriter($this->spreadsheet, 'Xlsx');

        // Save the new file
        dd($this->writer);
        $this->writer->save('php://output');
    }

    protected function rules()
    {
        if (!in_array($this->extension, $this->extensions)) {
            throw new \Exception('Invalid format specified.');
        }

        return true;
    }

    protected function setWriter()
    {
        switch ($this->extension) {
            case self::EXTENSION_XLSX:
                $this->writer = new Xlsx($this->spreadsheet);
                break;

            case self::EXTENSION_ODS:
                $this->writer = new Ods($this->spreadsheet);
                break;

            case self::EXTENSION_PDF:
                $this->writer = new Dompdf($this->spreadsheet);
                break;

            default:
        }

        return false;
    }

    protected function applyHeaders()
    {
        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: ' . $this->getContentType());
        header('Content-Disposition: attachment;filename="' . $this->getFilename() . '"');
        header('Cache-Control: max-age=0');

        if (in_array($this->extension, [self::EXTENSION_XLSX, self::EXTENSION_ODS])) {
            // Only apply to ODS and XLSX files
            // If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0
        }
    }

    /**
     * @return Spreadsheet
     */
    public function getSpreadsheet()
    {
        return $this->spreadsheet;
    }

    public function getFilename()
    {
        return $this->name . '.' . $this->extension;
    }

    protected function getContentType()
    {
        switch ($this->extension) {
            case self::EXTENSION_XLSX:
                return "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet";
                break;

            case self::EXTENSION_ODS:
                return "application/vnd.oasis.opendocument.spreadsheet";
                break;

            case self::EXTENSION_PDF:
                return "application/pdf";
                break;

            default:
        }

        return false;
    }
}
