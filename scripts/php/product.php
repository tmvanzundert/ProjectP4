<?php

    class Product {
        private string $Name;
        private string $Description;
        private float $Price;
        private string $ImagePath;
        private array $Usage;
        private array $Specifications;
        private string $Costs;

        public function __construct(string $Name, string $Description, float $Price, string $ImagePath, array $Usage = [], array $Specifications = [], string $Costs = '') {
            $this->Name = $Name;
            $this->Description = $Description;
            $this->Price = $Price;
            $this->ImagePath = $ImagePath;
            $this->Usage = $Usage;
            $this->Specifications = $Specifications;
            $this->Costs = $Costs;
        }

        private function getSimpleName(): string {
            return strtolower(str_replace(' ', '_', $this->Name));
        }

        public function getSearchableName(): string {
            return strtolower($this->Name);
        }

        public function getDescription(): string {
            return $this->Description;
        }

        public function createProductView(bool $FullPage = false): string {
            $productId = $FullPage ? "product-page" : "product";
            $simpleName = $this->getSimpleName();

            $extraDescription = "";
            
            if ($FullPage) {
                $listItems = [
                    __('productUsage') => $this->Usage,
                    __('productSpecifications') => $this->Specifications
                ];

                $extraDescription = "";
                
                foreach ($listItems as $title => $items) {
                    $extraDescription .= "<u>$title:</u><ul>";
                    foreach ($items as $item) {
                        $extraDescription .= "<li>$item</li>";
                    }
                    $extraDescription .= "</ul>";
                }

                $extraDescription .= "<u>" . __('productCosts') . ":</u>
                    <p>$this->Costs</p>";
            }

            return "
                <div id='$productId'>
                    " . ($FullPage === false ? "<a href='?view=product&product=$simpleName'>" : "") . "
                        " . ($FullPage === true ? "<a href='?view=producten' class='back-button'>Terug</a>" : "") . "
                        <h2 id='ProductTitle'>$this->Name</h2>
                        <img id='ProductImage' src='$this->ImagePath' alt='$this->Name'>
                        <span class='ProductPrice'>€" . number_format($this->Price, 2, ',', '.') . "</span>
                        <div>
                            <p>$this->Description</p>
                            $extraDescription
                        </div>
                    " . ($FullPage === false ? "</a>" : "") . "
                    <button class='ProductButton' onclick='window.location.href=\"?view=winkelwagen&product=$simpleName\"'>" . __('product_button') . "</button>
                </div>
            ";
        }
    }

?>
