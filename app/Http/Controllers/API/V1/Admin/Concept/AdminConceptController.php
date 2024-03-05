<?php

namespace App\Http\Controllers\API\V1\Admin\Concept;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Admin\Concept\ConceptCreateRequest;
use App\Http\Requests\API\V1\Admin\Concept\ConceptUpdateRequest;
use App\Services\Interfaces\ConceptInterface\AdminConceptInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminConceptController extends Controller
{

    public function __construct(private AdminConceptInterface $adminConcept)
    {
        //
    }


    /**
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        return $this->adminConcept->getAll();
    }


    /**
     * @param ConceptCreateRequest $request
     *
     * @return JsonResponse
     */
    public function create(ConceptCreateRequest $request): JsonResponse
    {
        $valid = $request->validated();

        return $this->adminConcept->create(data_: [
            'hotel_id'      => $valid['hotel_id'],
            'room_id'       => $valid['room_id'],
            'price'         => $valid['price'],
            'name'          => $valid['name'],
            'open_for_sale' => $valid['open_for_sale'],
        ]);
    }


    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function detail(int $id): JsonResponse
    {
        return $this->adminConcept->read(id: $id);
    }


    /**
     * @param ConceptUpdateRequest $request
     *
     * @return JsonResponse
     */
    public function update(ConceptUpdateRequest $request): JsonResponse
    {
        $valid = $request->validated();

        return $this->adminConcept->update(data_: [
            'id'            => $valid['id'],
            'hotel_id'      => $valid['hotel_id'],
            'room_id'       => $valid['room_id'],
            'price'         => $valid['price'],
            'name'          => $valid['name'],
            'open_for_sale' => $valid['open_for_sale'],
        ]);
    }


    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        return $this->adminConcept->delete(id: $id);
    }
}
