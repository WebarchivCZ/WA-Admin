<?php
/**
 * Table_Presenter je trida zajistujici prevedeni objektu (modelu, ale i jinych
 * do zobrazitelne tabulky
 *
 * @author Adam Brokes
 */
class Table_Presenter {
    private $header = '';
    private $footer = '';

    private $th_cells;
    private $td_cells;
    private $th_row = '';
    private $table_rows;

    public function __construct()
    {
        // inicializuje pocatecni promenne
        $this->th_cells = new ArrayObject();
        $this->td_cells = new ArrayObject();
        $this->table_rows = new ArrayObject();

    }

    /**
     * Prida hlavicku tabulky
     * @param string $value
     * @param array $attributes
     */
    public function add_th_cell($value, $attributes = NULL) {
        $cell = $this->add_cell('th', $value, $attributes);
        $this->th_row .= $cell;
    }

    /**
     * Prida bunku typu $tag
     * @param string $tag napr. td nebo th
     * @param string $value
     * @param string $attributes
     */
    public function add_cell($tag, $value, $attributes)
    {
        if (! is_null($attributes)) {
            $tag = $tag . html::attributes($attributes);

        }
        $cell_header = "<{$tag}>";
        $cell_footer = "</{$tag}>";
        $cell = $cell_header . $value . $cell_footer;

        $this->th_cells->append($cell);
        return $cell;
    }

    /**
     * Nastavi hlavicku tabulky
     * Napr. <div class='table'>
     * @param string $header
     */
    public function set_header($header)
    {
        $this->header = $header;
    }

    /**
     * Nastavi paticku tabulky
     * Napr. </div>
     * @param string $footer
     */
    public function set_footer($footer)
    {
        $this->footer = $footer;
    }

    /**
     * Vrati nebo vypise celou tabulku
     * @param bool $render
     * @return string
     */
    public function __toString($render = FALSE) {
        $output = $this->header;
        $output .= $this->th_row;
        $output .= $this->footer;
        if ($render) {
            echo $output;
        } else {
            return $output;
        }
    }
}
?>
