<?php

namespace App\Http\Resources;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * Class UserResource
 * @package App\Http\Resources
 */
class UserResource extends PlainResource
{
    public $token = null;
    public $maxLimit = false;
    private $tokenLimit = 1;
    private $toMuchSecure = true;
    private $messageBag = [];
    private $wantToken=false;

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {


        $data= ($this->maxLimit && $this->toMuchSecure) ? [
            'id' => $this->id,
            'name' => $this->name,
        ] : [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'avatar' => $this->avatar ?? asset("favicon.ico"),
            'locale' => $this->locale ?? config("app.locale"),
            'active' => $this->active,
            'roles' => $this->getRoleNames(),
            'permission' => $this->getDirectPermissions(),
            'gender' => $this->getMeta('gender'),
            'company' =>CompanyResource::collection((!$this->whenLoaded('company'))?$this->whenLoaded('company')->take(5):[])
        ];

        if($this->wantToken) {
            $data['token']=$this->getToken($request);
        }

        return  $data;
    }

    private function getToken(Request $request)
    {
       // $this->addMsg('debug', $request->all());
        return $this->token ?? $this->getNewToken($request);
    }

    private function addMsg($key, $message)
    {
        $this->messageBag[$key][] = $message;
    }

    private function getNewToken(Request $request)
    {
        $device = $this->getDevice($request, "o");
        $devices = auth()->user()->devices->where('name', $device['name']);

        if (!$devices->count()) {
            if (auth()->user()->devices->count() > $this->tokenLimit) {
                $this->maxLimit = true;
                $this->addAlert("Max Logged in device limit reached");
                return;
            }
            $device = new Device($this->getDevice($request));
            $device->user_id = auth()->id();
            $device->save();
        } else {
            $device = $devices->first();
        }
        $this->setToken($device->token);
        return $this->token;
    }

    private function getDevice(Request $request, $token = null)
    {
        if ($token === null) {
            $token = $this->createAccessToken($this->getDeviceName($request));
            $this->setToken($token);
        }
        return [
            'token' => $this->token,
            'name' => $this->getDeviceName($request),
            'type' => "mobile",
            'os_version' => "android.8",
        ];
    }

    private function getDeviceName(Request $request, $default = "")
    {
        return $request->has('device_name') ? $request->get('device_name') : $default;
    }

    private function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    private function addAlert($message)
    {
        $this->addMsg('alert', $message);
    }

    public function with($request)
    {
        return $this->messageBag;
    }

    private function addMessage($message)
    {
        $this->addMsg('message', $message);
    }
    public function withToken(){
        if(!$this->wantToken)$this->wantToken=true;
        return $this;
    }

    public function secured(){
        if(!$this->toMuchSecure)$this->toMuchSecure=true;
        if(!$this->maxLimit)$this->maxLimit=true;
        return $this;
    }

}
