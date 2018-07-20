<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pages;
use Validator;

class PagesController extends Controller
{
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
     * pages/add
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
     * pages/{id}
     * 
     * @param integer id | required
     * 
     * @return one page
     */
    public function getPage($id)
    {
        $page = Pages::find($id);
        return response()->json($page);
    }

    /**
     * pages
     * 
     * @return all pagess list
     */
    public function getPagesList()
    {
        $pages = Pages::all();
        return response()->json($pages);
    }

    /**
     * pages/set-visible/{id}
     * 
     * @param integer id | required
     * 
     * @return void
     */
    public function setPageVisible($id)
    {
        $page = Pages::find($id);
        $page->visibility = 1;
        $page->save();
        return response()->json($page);
    }

    /**
     * pages/set-invisible/{id}
     * 
     * @param integer id | required
     * 
     * @return void
     */
    public function setPageInvisible($id)
    {
        $page = Pages::find($id);
        $page->visibility = 0;
        $page->save();
        return response()->json($page);
    }

    /**
     * pages/delete/{id}
     * 
     * @param integer id | required
     * 
     * @return void
     */
    public function deletePage($id)
    {
        $page = Pages::find($id);
        $page->delete();
        return response()->json(['success'=>'Podstrona została usunięta.']);
    }

    /**
     * pages/update-content/{id}
     * 
     * @param string content | optional
     * @param integer id | required
     */
    public function updateContent(Request $request, $id)
    {
        $page = Pages::find($id);
        $page->content = $request->content;
        $page->save();
        return response()->json($page);
    }
}

/**
 * http://sip.umradom.pl/inteligentne_specjalizacje_motorem_rozwoju_lokalnego_rynku_pracy.html?PHPSESSID1=
 */


