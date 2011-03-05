<?php
/**
 * @version $Id$
 * @copyright Center for History and New Media, 2008-2011
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @package CsvImport
 */

/**
 * The form on csv-import/index/map-columns.
 *
 * @package CsvImport
 * @author CHNM
 * @copyright Center for History and New Media, 2008-2011
 */
class CsvImport_Form_Mapping extends Omeka_Form
{
    private $_file;
    private $_itemTypeId;
    
    const TAG_CHECKBOX_PREFIX = 'map_tag_';
    const FILE_CHECKBOX_PREFIX = 'map_file_';
    const HTML_CHECKBOX_PREFIX = 'map_html_';
    const ELEMENTS_LIST_PREFIX = 'map_elements_list_';
    const ELEMENTS_DROPDOWN_PREFIX = 'map_elements_dropdown_';
    const ELEMENTS_HIDDEN_PREFIX = 'map_elements_hidden_';

    public function init()
    {
        parent::init();
        $this->setAttrib('id', 'csvimport-mapping');
        $this->setMethod('post'); 

        $elementsByElementSetName = 
            csv_import_get_elements_by_element_set_name($this->itemTypeId);
        array_unshift($elementsByElementSetName, 'Select Below');
        foreach ($this->_file->getColumnNames() as $index => $colName) {
            $this->addElement('select',
                self::ELEMENTS_DROPDOWN_PREFIX . $index,
                array(
                    'class' => 'csv-import-element-select',
                    'multiOptions' => $elementsByElementSetName,
                )
            );
            $this->addElement('hidden', 
                self::ELEMENTS_HIDDEN_PREFIX . $index);
            $this->addElement('checkbox',
                self::HTML_CHECKBOX_PREFIX . $index);
            $this->addElement('checkbox',
                self::TAG_CHECKBOX_PREFIX . $index);
            $this->addElement('checkbox',
                self::FILE_CHECKBOX_PREFIX . $index);
        }

        $this->addElement('submit', 'submit',
            array('label' => 'Import CSV File',
                  'class' => 'submit submit-medium'));
    }

    public function loadDefaultDecorators()
    {
        $this->setDecorators(array(
            array('ViewScript', array(
                'viewScript' => 'index/map-columns-form.php',
                'file' => $this->_file,
                'itemTypeId' => $this->_itemTypeId,
                'form' => $this,
            )),
        ));
    }

    public function setFile(CsvImport_File $file)
    {
        $this->_file = $file;
    }

    public function setItemTypeId($itemTypeId)
    {
        $this->_itemTypeId = $itemTypeId;
    }
}
