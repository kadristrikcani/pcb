<?php

namespace App\Service;

use RuntimeException;
use Exception;
use Podio;
use PodioApp;
use PodioEmailItemField;
use PodioItem;
use PodioItemFieldCollection;
use PodioMissingRelationshipError;
use PodioPhoneItemField;
use PodioTextItemField;
use App\Entity\Request as RequestEntity;
use Symfony\Component\HttpKernel\KernelInterface;

class PodioService
{

    private const clientID = 'premiumcashbuyers';
    private const clientSecret = 'KEDGe27FBpXZarwQHOr3l2GN9MnfWILtiPXHRBJMNPGd179GyR3aKJhfYJYgWtTr';
    private const appID = 28762650;
    private const appToken = '5599f7448299ef0077bcfd784c0af078';
    private string $environment;

    public function __construct(KernelInterface $kernel)
    {
        $this->environment = $kernel->getEnvironment();
        $this->initService();
    }

    private function initService(): void
    {
        $options = ($this->environment === 'dev') ? ['curl_options' => [CURLOPT_SSL_VERIFYPEER => false]] : [];
        Podio::setup(self::clientID, self::clientSecret, $options);
        Podio::authenticate_with_app(self::appID, self::appToken);
    }

    /**
     * @throws PodioMissingRelationshipError
     * @throws Exception
     */
    public function sendResponse(RequestEntity $request)
    {
        $fields = $this->buildFieldsFromFormData($request);

        $item = new PodioItem(array(
            'app' => new PodioApp(self::appID),
            'fields' => new PodioItemFieldCollection($fields)
        ));

        if ($item->save()) {
            // Получаем item_id
            return $item->item_id;
        }

        throw new RuntimeException('Error!');
    }

    public function updatePodioItem(RequestEntity $request): int
    {
        $existingItem = PodioItem::get($request->getPodioId());
        $fields = $this->buildFieldsFromFormData($request);
        $existingItem->fields = new PodioItemFieldCollection($fields);
        if ($existingItem->save()) {
            return $existingItem->item_id;
        }
        throw new RuntimeException('Error updating item!');
    }

    public function deletePodioItem(int $itemId): void
    {
        $existingItem = PodioItem::get($itemId);
        if (!$existingItem->delete($itemId)) {
            throw new RuntimeException('Error deleting item!');
        }
    }

    private function buildFieldsFromFormData(RequestEntity $request): array
    {
        $fields = [];

        $fieldMapping = [
            'name' => '253887608',
            'phone' => '253887711',
            'address' => '253887706',
            'ownerStatus' => '253887707',
            'sellingReason' => '254058309',
            'listed' => '257040120',
            'utmData' => '255060426',
            'partialConversion' => '256035804'
        ];

        foreach ($fieldMapping as $fieldKey => $externalId) {
            $value = $request->{'get' . ucfirst($fieldKey)}();
            if ($value) {
                if ($fieldKey === 'phone') {
                    $fields[] = new PodioPhoneItemField(array("external_id" => $externalId, "values" => ['type' => 'work', 'value' => $value]));
                } elseif ($fieldKey === 'email') {
                    $fields[] = new PodioEmailItemField(array("external_id" => $externalId, "values" => ['type' => 'other', 'value' => $value]));
                } else {
                    $fields[] = new PodioTextItemField(array("external_id" => $externalId, "values" => $value));
                }
            }
        }

        return $fields;
    }

    public function getItems(): int
    {
        $items = PodioItem::filter(self::appID);
        return count($items);
    }

}