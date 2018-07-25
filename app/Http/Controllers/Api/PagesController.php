<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pages;
use Validator;
use App\ApiKeys;

class PagesController extends Controller
{
    /**
     * chcekApiKey
     * @param apiKey
     * @return boolean
    */
    private function chcekApiKey($key) {
        $apiKeys = new ApiKeys();
        return $apiKeys->chcekApiKey($key);
    }
    
    /**
     * error Invalid Api Key
     * 
     * @return info
     */
    private function invalidApiKey() {
        $apiInfo = new ApiKeys();
        return response()->json(['error' =>  $apiInfo->invalidApiKey()]);
    }

    /**
     * issetPage
     * 
     * @param string name of new page
     * 
     * @return boolean
     */
    private function issetPage($name)
    {
        $page = Pages::where('name', $name)->first();
        if (count($page)==0) return false;
        return true;
    }                                                   

    /**
     * issetSlug
     * 
     * @param string slug of new page
     * 
     * @return boolean
     */
    private function issetSlug($slug)
    {
        $page = Pages::where('slug', $slug)->first();
        if (count($page)!=0) return true;
        return false;
    }

    /** 
     * ==========================================================================================================
     * ========================================================================================================== 
     * ========================================================================================================== 
     */

    /**
     * pages/add/key/{key}
     * 
     * @param string name | required
     * @param string slug | required
     * 
     * @return void
     */
    public function addPage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:1',
            'slug' => 'required|min:1'
        ]);

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        if ($this->issetPage($request->name) == true) {
           return response()->json(['error'=>'The page name is busy!'], 401);
        }

        if ($this->issetSlug($request->slug) == true) {
           return response()->json(['error'=>'The slug name is busy!'], 401);
        }

        $page = Pages::create($request->all());
        return response()->json(['success' => 'Podstrona została dodana.'], 200);
    }

    /**
     * pages/{id}/key/{key}
     * 
     * @param integer id | required
     * @param string key | required
     * 
     * @return one page
     */
    public function getPage($id, $key)
    {
        if($this->chcekApiKey($key)) {
            $page = Pages::find($id);
            return response()->json($page);
        }
        return $this->invalidApiKey();
    }

    /**
     * pages/key/{key}
     * 
     * @param string key | required
     * 
     * @return all pagess list
     */
    public function getPagesList($key)
    {
        if($this->chcekApiKey($key)) {
            $pages = Pages::all();
            return response()->json($pages);
        }
        return $this->invalidApiKey();
    }

    /**
     * pages/{id}/set-visible//key/{key}
     * 
     * @param integer id | required
     * @param string key | required
     * 
     * @return void
     */
    public function setPageVisible($id, $key)
    {
        if($this->chcekApiKey($key)) {
            $page = Pages::find($id);
            $page->visibility = 1;
            $page->save();
            return response()->json($page);
        }
        return $this->invalidApiKey();
    }

    /**
     * pages/{id}/set-invisible/key/{key}
     * 
     * @param integer id | required
     * @param string key | required
     * 
     * @return void
     */
    public function setPageInvisible($id, $key)
    {
        if($this->chcekApiKey($key)) {
            $page = Pages::find($id);
            $page->visibility = 0;
            $page->save();
            return response()->json($page);
        }
        return $this->invalidApiKey();
    }

    /**
     * pages/{id}/delete/key/{key}
     * 
     * @param integer id | required
     * @param string key | required
     * 
     * @return void
     */
    public function deletePage($id, $key)
    {
        if($this->chcekApiKey($key)) {
            $page = Pages::find($id);
            $page->delete();
            return response()->json(['success'=>'Podstrona została usunięta.']);
        }
        return $this->invalidApiKey();
    }

    /**
     * pages/{id}/update-content/key/{key}
     * 
     * @param string content | optional
     * @param integer id | required
     * @param string key | required
     */
    public function updateContent(Request $request, $id, $key)
    {
        if($this->chcekApiKey($key)) {
            $page = Pages::find($id);
            $page->content = $request->content;
            $page->save();
            return response()->json($page);
        }
        return $this->invalidApiKey();
        
    }
}

