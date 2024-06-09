<?php

namespace App\Console\Commands;

use App\Models\Merchant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportOldMerchants extends Command
{
    protected $signature = 'shop:import-old-merchants';

    public function handle()
    {
        DB::table('merchants')->truncate();
        DB::table('addresses')->where('addressable_type', 'merchant')->delete();

        $siteMap = [
            'default' => 'old',
            'suisse' => 'old_suisse',
        ];

        $addressTypes = [
            1 => 'invoice',
            2 => 'shipping',
            3 => 'shop',
            4 => 'main',
        ];

        $countryIsos = [
            'default' => 'DE',
            'suisse' => 'CH',
        ];

        foreach ($siteMap as $site => $connection) {
            $oldMerchants = DB::connection($connection)
                ->table('customers')
                ->where('is_merchant', true)
                ->get();

            foreach ($oldMerchants as $oldMerchant) {
                $newMerchant = Merchant::create([
                    'active_child_number' => $oldMerchant->active_merchant_child_number,
                    'can_order_for_children' => $oldMerchant->can_order_for_children,
                    'can_pay_online' => $oldMerchant->merchant_can_pay_online,
                    'can_see_prices' => $oldMerchant->hide_merchant_prices ? 0 : 1,
                    'discount_percentage' => $oldMerchant->merchant_discount,
                    'email' => $oldMerchant->email,
                    'facebook_url' => $oldMerchant->facebook_url,
                    'first_login_at' => $oldMerchant->first_login_at,
                    'first_name' => $oldMerchant->first_name,
                    'free_limit' => $oldMerchant->merchant_free_limit * 100,
                    'has_download_access' => $oldMerchant->has_download_access,
                    'has_login' => $oldMerchant->has_merchant_login,
                    'has_seen_news' => $oldMerchant->merchant_has_seen_news,
                    'inactive_after_login_mail_sent' => $oldMerchant->inactive_after_login_mail_sent,
                    'instagram_url' => $oldMerchant->instagram_url,
                    'internal_address_key' => $oldMerchant->merchant_address_id,
                    'invoice_email_only' => $oldMerchant->merchant_invoice_email_only,
                    'is_blocked' => $oldMerchant->merchant_is_blocked,
                    'is_in_list' => $oldMerchant->in_merchant_list,
                    'last_name' => $oldMerchant->last_name,
                    'master_number' => $oldMerchant->master_merchant_number,
                    'number' => $oldMerchant->merchant_number,
                    'password' => $oldMerchant->password,
                    'payment_terms' => $oldMerchant->merchant_payment_terms,
                    'shipping' => $oldMerchant->merchant_shipping,
                    'show_availability' => $oldMerchant->dont_show_availability ? 0 : 1,
                    'site' => $site,
                    'special_marker' => $oldMerchant->special_marker,
                    'token' => $oldMerchant->token,
                    'vat_percentage' => $oldMerchant->merchant_vat,
                    'website' => $oldMerchant->website,
                ]);

                $oldAddresses = DB::connection($connection)
                    ->table('customer_addresses')
                    ->where('customer_id', $oldMerchant->id)
                    ->get();

                foreach ($oldAddresses as $oldAddress) {
                    $newMerchant->addresses()->create([
                        'type' => $addressTypes[$oldAddress->address_kind_id],
                        'phone' => $oldAddress->phone,
                        'country_iso' => $countryIsos[$site],
                        'email' => $oldAddress->email,
                        'first_name' => $oldAddress->first_name,
                        'last_name' => $oldAddress->last_name,
                        'company' => $oldAddress->company,
                        'street' => $oldAddress->street,
                        'postcode' => $oldAddress->zip,
                        'additional_field' => $oldAddress->street_continued,
                        'department' => $oldAddress->department,
                        'internal_address_key' => $oldAddress->merchant_address_id,
                    ]);
                }
            }
        }

        $this->info('done importing old merchants.');
    }
}
