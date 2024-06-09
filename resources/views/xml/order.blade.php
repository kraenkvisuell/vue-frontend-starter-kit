@inject('numberHelper', 'App\Service\NumberService')
@php echo '<?xml version="1.0" encoding="UTF-8"?>' @endphp
<ORDER xmlns="http://www.opentrans.org/opentrans/1.0/opentrans_order" version="1.0" type="standard">
    <ORDER_HEADER>
        <CONTROL_INFO>
            <GENERATOR_INFO>Created by ZWEI Custom Shop Application</GENERATOR_INFO>
            <GENERATION_DATE>{{ $createdAt }}</GENERATION_DATE>
        </CONTROL_INFO>
        <ORDER_INFO>
            <ORDER_CID>B2C</ORDER_CID>
            <ORDER_ID>{{ $order->order_number }}</ORDER_ID>
            <ORDER_DATE>{{ $createdAt }}</ORDER_DATE>
            <ORDER_PARTIES>
                <BUYER_PARTY>
                    <PARTY>
                        <PARTY_ID
                            type="buyer_specific"></PARTY_ID>
                        <ADDRESS>
                            <GRUPPE>taschenonline</GRUPPE>
                            <BRUTTO>Ja</BRUTTO>
                            <CUSTOMERNR>{{ $order->customer_id }}</CUSTOMERNR>
                            <NAME>{{ $order->invoice_address->company ?: $order->invoice_address->full_name }}</NAME>
                            <NAME2>{{ $order->invoice_address->company ? $order->invoice_address->full_name : '' }}</NAME2>
                            <NAME3 />
                            <DEPARTMENT />
                            <CONTACT>
                                <CONTACT_NAME />
                                <PHONE type="office">{{ $order->invoice_address->phone }}</PHONE>
                                <FAX />
                                <EMAIL>{{ $order->invoice_address->email }}</EMAIL>
                                <PUBLIC_KEY type="" />
                                <URL></URL>
                            </CONTACT>
                            <STREET>{{ $order->invoice_address->street }}</STREET>
                            <ZIP>{{ $order->invoice_address->postcode }}</ZIP>
                            <BOXNO />
                            <ZIPBOX />
                            <CITY>{{ $order->invoice_address->city }}</CITY>
                            <STATE />
                            <COUNTRY>{{ $order->invoice_address->country_iso }}</COUNTRY>
                            <VAT_ID />
                            <PHONE type="office">{{ $order->invoice_address->phone }}</PHONE>
                            <FAX />
                            <EMAIL>{{ $order->invoice_address->email }}</EMAIL>
                            <URL />
                        </ADDRESS>
                    </PARTY>
                </BUYER_PARTY>
                <SUPPLIER_PARTY>
                    <PARTY>
                        <PARTY_ID type="supplier_specific" />
                        <ADDRESS type="office">
                            <NAME />
                            <NAME2 />
                            <NAME3 />
                            <DEPARTMENT />
                            <CONTACT>
                                <CONTACT_NAME />
                                <PHONE type="office" />
                                <FAX />
                                <EMAIL />
                                <PUBLIC_KEY type="" />
                                <URL />
                            </CONTACT>
                            <STREET />
                            <ZIP />
                            <BOXNO />
                            <ZIPBOX />
                            <CITY />
                            <STATE />
                            <COUNTRY />
                            <VAT_ID />
                            <PHONE />
                            <FAX />
                            <EMAIL />
                            <URL />
                        </ADDRESS>
                    </PARTY>
                </SUPPLIER_PARTY>
                <INVOICE_PARTY>
                    <PARTY>
                        <PARTY_ID
                            type="buyer_specific"></PARTY_ID>
                        <ADDRESS>
                            <GRUPPE>taschenonline</GRUPPE>
                            <BRUTTO>Ja</BRUTTO>
                            <CUSTOMERNR></CUSTOMERNR>
                            <NAME>{{ $order->invoice_address->company ?: $order->invoice_address->full_name }}</NAME>
                            <NAME2>{{ $order->invoice_address->company ? $order->invoice_address->full_name : '' }}</NAME2>
                            <NAME3 />
                            <DEPARTMENT />
                            <CONTACT>
                                <CONTACT_NAME />
                                <PHONE type="office">{{ $order->invoice_address->phone }}</PHONE>
                                <FAX />
                                <EMAIL>{{ $order->invoice_address->email }}</EMAIL>
                                <PUBLIC_KEY type="" />
                                <URL></URL>
                            </CONTACT>
                            <STREET>{{ $order->invoice_address->street }}</STREET>
                            <ZIP>{{ $order->invoice_address->postcode }}</ZIP>
                            <BOXNO />
                            <ZIPBOX />
                            <CITY>{{ $order->invoice_address->city }}</CITY>
                            <STATE />
                            <COUNTRY>{{ $order->invoice_address->country_iso }}</COUNTRY>
                            <VAT_ID />
                            <PHONE type="office">{{ $order->invoice_address->phone }}</PHONE>
                            <FAX />
                            <EMAIL>{{ $order->invoice_address->email }}</EMAIL>
                            <URL />
                        </ADDRESS>
                    </PARTY>
                </INVOICE_PARTY>
                <SHIPMENT_PARTIES>
                    <DELIVERY_PARTY>
                        <PARTY>
                            <PARTY_ID
                                type="buyer_specific"></PARTY_ID>
                            <ADDRESS>
                                <GRUPPE>taschenonline</GRUPPE>
                                <BRUTTO>Ja</BRUTTO>
                                <CUSTOMERNR></CUSTOMERNR>
                                <NAME>{{ $order->shipping_address->company ?: $order->shipping_address->full_name }}</NAME>
                                <NAME2>{{ $order->shipping_address->company ? $order->shipping_address->full_name : '' }}</NAME2>
                                <NAME3 />
                                <DEPARTMENT />
                                <CONTACT>
                                    <CONTACT_NAME />
                                    <PHONE type="office">{{ $order->shipping_address->phone }}</PHONE>
                                    <FAX />
                                    <EMAIL>{{ $order->shipping_address->email }}</EMAIL>
                                    <PUBLIC_KEY type="" />
                                    <URL></URL>
                                </CONTACT>
                                <STREET>{{ $order->shipping_address->street }}</STREET>
                                <ZIP>{{ $order->shipping_address->postcode }}</ZIP>
                                <BOXNO />
                                <ZIPBOX />
                                <CITY>{{ $order->shipping_address->city }}</CITY>
                                <STATE />
                                <COUNTRY>{{ $order->shipping_address->country_iso }}</COUNTRY>
                                <VAT_ID />
                                <PHONE type="office">{{ $order->shipping_address->phone }}</PHONE>
                                <FAX />
                                <EMAIL>{{ $order->shipping_address->email }}</EMAIL>
                                <URL />
                            </ADDRESS>
                        </PARTY>
                    </DELIVERY_PARTY>
                    <TRANSPORT_PARTY>
                        <PARTY>
                            <PARTY_ID type="supplier_specific">Versand</PARTY_ID>
                            <ADDRESS>
                                <NAME>Versand</NAME>
                            </ADDRESS>
                        </PARTY>
                    </TRANSPORT_PARTY>
                </SHIPMENT_PARTIES>
            </ORDER_PARTIES>
            <PRICE_CURRENCY>{{ config('shop.default_currency') }}</PRICE_CURRENCY>
            <PAYMENT>
                <CASH>
                    <PAYMENT_TERM>{{ $order->payment_kind?->name }}</PAYMENT_TERM>
                    <PAYMENT_CONDITION></PAYMENT_CONDITION>
                </CASH>
            </PAYMENT>
            <REMARK type="order">{{ $order->message }}</REMARK>
        </ORDER_INFO>
    </ORDER_HEADER>
    <ORDER_ITEM_LIST>
        @foreach($order->skus as $sku)
            <ORDER_ITEM>
                <LINE_ITEM_ID>{{ $sku->id }}</LINE_ITEM_ID>
                <ARTICLE_ID>
                    <SUPPLIER_AID>{{ $sku->is_voucher ? 'Gutschein' : strtoupper($sku->title) }}</SUPPLIER_AID>
                    <DESCRIPTION_SHORT />
                    <DESCRIPTION_LONG />
                    <DESCRIPTION_ZUS>{{ $sku->productcode_code ? 'Rabattcode: '.strtoupper($sku->productcode_code) : '' }}</DESCRIPTION_ZUS>
                </ARTICLE_ID>
                <QUANTITY>{{ $sku->quantity }}</QUANTITY>
                <ORDER_UNIT />
                <ARTICLE_PRICE type="net_list">
                    <PRICE_AMOUNT>{{ $numberHelper->floatFromString($sku->readable_price) }}</PRICE_AMOUNT>
                    <PRICE_LINE_AMOUNT>{{ $numberHelper->floatFromString($sku->readable_sum) }}</PRICE_LINE_AMOUNT>
                    <TAX>{{ $vat/100 }}</TAX>
                    <TAX_AMOUNT>{{ $numberHelper->floatFromString($sku->readable_sum_vat) }}</TAX_AMOUNT>
                </ARTICLE_PRICE>
            </ORDER_ITEM>
            @if($sku->packaging_number)
                <ORDER_ITEM>
                    <LINE_ITEM_ID>{{ $sku->id.'-'.$sku->packaging_number }}</LINE_ITEM_ID>
                    <ARTICLE_ID>
                        <SUPPLIER_AID>{{ strtoupper($sku->packaging_number) }}</SUPPLIER_AID>
                        <DESCRIPTION_SHORT />
                        <DESCRIPTION_LONG />
                        <DESCRIPTION_ZUS>{{ $sku->packaging_name }}</DESCRIPTION_ZUS>
                    </ARTICLE_ID>
                    <QUANTITY>{{ $sku->quantity }}</QUANTITY>
                    <ORDER_UNIT />
                    <ARTICLE_PRICE type="net_list">
                        <PRICE_AMOUNT>{{ ($order->validForFreeBox() ? '0' : $numberHelper->floatFromString($sku->readable_packaging_price)) }}</PRICE_AMOUNT>
                        <PRICE_LINE_AMOUNT>{{ ($order->validForFreeBox() ? '0' : $numberHelper->floatFromString($sku->readable_packaging_sum)) }}</PRICE_LINE_AMOUNT>
                        <TAX>{{ $vat/100 }}</TAX>
                        <TAX_AMOUNT>{{ ($order->validForFreeBox() ? '0' : $numberHelper->floatFromString($sku->readable_packaging_sum_vat)) }}</TAX_AMOUNT>
                    </ARTICLE_PRICE>
                </ORDER_ITEM>
            @endif
        @endforeach

        @foreach($order->voucher_usages ?? [] as $usage)
            <ORDER_ITEM>
                <LINE_ITEM_ID>{{ $usage->voucher->code }}</LINE_ITEM_ID>
                <ARTICLE_ID>
                    <SUPPLIER_AID>GUTSCHEIN</SUPPLIER_AID>
                    <DESCRIPTION_SHORT />
                    <DESCRIPTION_LONG />
                    <DESCRIPTION_ZUS>ZWEI Online Gutschein {{ $usage->voucher->code }}</DESCRIPTION_ZUS>
                </ARTICLE_ID>
                <QUANTITY>1</QUANTITY>
                <ORDER_UNIT />
                <ARTICLE_PRICE type="net_list">
                    <PRICE_AMOUNT>-{{ $usage->readable_amount }}</PRICE_AMOUNT>
                    <PRICE_LINE_AMOUNT>-{{ $usage->readable_amount }}</PRICE_LINE_AMOUNT>
                    <TAX></TAX>
                    <TAX_AMOUNT></TAX_AMOUNT>
                </ARTICLE_PRICE>
            </ORDER_ITEM>
        @endforeach

        @if($order->co2_price_accepted && $order->totalCo2Price())
            <ORDER_ITEM>
                <LINE_ITEM_ID>CO2COMP</LINE_ITEM_ID>
                <ARTICLE_ID>
                    <SUPPLIER_AID>CO2COMP</SUPPLIER_AID>
                    <DESCRIPTION_SHORT />
                    <DESCRIPTION_LONG />
                    <DESCRIPTION_ZUS></DESCRIPTION_ZUS>
                </ARTICLE_ID>
                <QUANTITY>{{ $order->co2PriceQuantity() }}</QUANTITY>
                <ORDER_UNIT />
                <ARTICLE_PRICE type="net_list">
                    <PRICE_AMOUNT>{{ $numberHelper->floatFromString($order->readableCo2Price()) }}</PRICE_AMOUNT>
                    <PRICE_LINE_AMOUNT>{{ $numberHelper->floatFromString($order->readableTotalCo2Price()) }}</PRICE_LINE_AMOUNT>
                    <TAX>{{ $vat/100 }}</TAX>
                    <TAX_AMOUNT>{{ number_format($co2PriceTax * $order->co2PriceQuantity(), 2) }}</TAX_AMOUNT>
                </ARTICLE_PRICE>
            </ORDER_ITEM>
        @endif
        @if($order->plastic_compensation_accepted && $order->totalPlasticCompensation())
            <ORDER_ITEM>
                <LINE_ITEM_ID>OPCOMP</LINE_ITEM_ID>
                <ARTICLE_ID>
                    <SUPPLIER_AID>OPCOMP</SUPPLIER_AID>
                    <DESCRIPTION_SHORT />
                    <DESCRIPTION_LONG />
                    <DESCRIPTION_ZUS></DESCRIPTION_ZUS>
                </ARTICLE_ID>
                <QUANTITY>{{ $order->plasticCompensationQuantity() }}</QUANTITY>
                <ORDER_UNIT />
                <ARTICLE_PRICE type="net_list">
                    <PRICE_AMOUNT>{{ $numberHelper->floatFromString($order->readablePlasticCompensation()) }}</PRICE_AMOUNT>
                    <PRICE_LINE_AMOUNT>{{ $numberHelper->floatFromString($order->readableTotalPlasticCompensation()) }}</PRICE_LINE_AMOUNT>
                    <TAX>{{ $vat/100 }}</TAX>
                    <TAX_AMOUNT>{{ number_format($plasticCompensationTax * $order->plasticCompensationQuantity(), 2) }}</TAX_AMOUNT>
                </ARTICLE_PRICE>
            </ORDER_ITEM>
        @endif
        @if($order->shippingCosts())
            <ORDER_ITEM>
                <LINE_ITEM_ID>#shipment</LINE_ITEM_ID>
                <ARTICLE_ID>
                    <SUPPLIER_AID>Versand</SUPPLIER_AID>
                    <DESCRIPTION_SHORT>Versand</DESCRIPTION_SHORT>
                    <DESCRIPTION_LONG>Versand</DESCRIPTION_LONG>
                </ARTICLE_ID>
                <QUANTITY>1</QUANTITY>
                <ORDER_UNIT>x</ORDER_UNIT>
                <ARTICLE_PRICE type="net_list">
                    <PRICE_AMOUNT>{{ $numberHelper->floatFromString($order->shippingCosts()) }}</PRICE_AMOUNT>
                    <PRICE_LINE_AMOUNT>{{ $numberHelper->floatFromString($order->shippingCosts()) }}</PRICE_LINE_AMOUNT>
                    <TAX>{{ $vat/100 }}</TAX>
                    <TAX_AMOUNT>{{ $numberHelper->floatFromString($order->shippingCostsVat()) }}</TAX_AMOUNT>
                </ARTICLE_PRICE>
            </ORDER_ITEM>
        @endif
    </ORDER_ITEM_LIST>
    <ORDER_SUMMARY>
        <TOTAL_ITEM_NUM>{{ $order->total_quantity }}</TOTAL_ITEM_NUM>
        <TOTAL_AMOUNT>{{ $numberHelper->floatFromString($order->totalInclVat()) }}</TOTAL_AMOUNT>
    </ORDER_SUMMARY>
    <REFERENCETEXT />
    <PAYMENT_DATE></PAYMENT_DATE>
    <Paypal></Paypal>
    <DELIVERY_DATE></DELIVERY_DATE>
</ORDER>
