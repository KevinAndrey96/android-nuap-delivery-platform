<?php
namespace App\Http\Transformers;

use App\Models\Commerce;
use App\Models\User;
use League\Fractal\TransformerAbstract;
use App\Repositories\Contracts\DbBalanceRepositoryInterface;

/**
 * Class CommerceTransformer
 * @package App\Http\Transformers
 */
class CommerceTransformer extends TransformerAbstract
{
    /**
     * @var DbBalanceRepositoryInterface
     */
    private $dbBalanceRepository;

    /**
     * LoginTransformer constructor.
     * @param DbBalanceRepositoryInterface $dbBalanceRepository
     */
    public function __construct(
        DbBalanceRepositoryInterface $dbBalanceRepository
    ) {
        $this->dbBalanceRepository = $dbBalanceRepository;
    }
    
    /**
     * @param Commerce $item
     * @return array
     */
    public function transform(Commerce $item): array
    {
        return [
            'id' => $item->id,
            'email' => $item->email,
            'phone' => $item->phone,
            'status' => $item->status,
            'business_name' => $item->business_name,
            'nit' => $item->nit,
            'commission' => $item->commission.'%',
            'url_logo' => $item->url_logo,
            'shipping_cost' => $this->formatCurrency($item->shipping_cost),
            'distance' => $item->distance.'km',
            'balance' => $this->getBalance($item)
        ];
    }
    
    /**
     * @param User $user
     * @return string
     */
    private function getBalance(Commerce $user): string
    {
        if ($user->role === User::COMMERCE_ROLE) {
            $balance = $this->dbBalanceRepository->findByUserID($user->user_id);
            if (! is_null($balance)) {
                $balance->requested_value = '$ '.$this->formatCurrency($balance->requested_value);
                return $balance->requested_value;
            }
            return '$ 0';
        }

        return '';
    }

    /**
     * @param $floatcurr
     * @param string $curr
     * @return string
     */
    public function formatCurrency($floatcurr, $curr = "COP"): string
    {
        $currencies['COP'] = array(0,',','.');
        return number_format($floatcurr, $currencies[$curr][0], $currencies[$curr][1], $currencies[$curr][2]);
    }
}
