<?php namespace Project\Controllers;

use Restful;
use Method;
use Validation;
use File;
use Folder;
use Session;
use Cookie;
use Json;
use URI;
use Security;
use Http;
use Redirect;
use Lang;
use URL;

class Home extends Controller
{
    /**
     * Main Page
     */
    public function main(String $params = NULL)
    {
        if( Method::post('create') )
        {
            Validation::rules('project', ['alpha'], 'Project Name');

            if( ! $error = Validation::error('string') )
            {
                $source = EXTERNAL_FILES_DIR . 'DefaultProject.zip';
                $target = PROJECTS_DIR . Method::post('project');

                File::zipExtract($source, $target);
                
                Redirect::location(URI::current(), 0, ['success' => LANG['success']]);
            }
            else
            {
                Masterpage::error($error);
            }
        }
        
        if( ! $return = Session::select('return') )
        {
            $return = Restful::get('https://api.znframework.com/statistics');

            Session::insert('return', $return);
        }
        
        Masterpage::page('dashboard');
        Masterpage::pdata(['return' => $return]);
    }

    /**
     * Docs Page
     */
    public function docs(String $params = NULL)
    {
        $docs = FILES_DIR . 'docs.json';

        if( Method::post('refresh') )
        {
            File::delete($docs);
            clearstatcache();
        }

        if( ! File::exists($docs) )
        {
            $return = Restful::get('https://api.znframework.com/docs');

            if( ! empty($return) )
            {
                File::write($docs, Json::encode($return));
            }
        }
        else
        {
            $return = Json::decode(File::read($docs));
        }

        \Import::handload('Functions');

        Masterpage::plugin(['name' => [
            'Dashboard/highlight/styles/agate.css',
            'Dashboard/highlight/highlight.pack.js'
        ]]);

        Masterpage::pdata(['docs' => $return]);
      
        Masterpage::page('docs');
    }

    /**
     * Delete
     */
    public function delete($project = NULL)
    {
        if( ! empty($project) )
        {
            $path = PROJECTS_DIR . $project;

            if( Folder::exists($path) )
            {
                Session::delete('project');
                Folder::delete($path);
            }
        }

        Redirect::location((string) URL::prev(), 0, ['success' => LANG['success']]);
    }

    /**
     * Delete Backup
     */
    public function deleteBackup($backup = NULL)
    {
        $path = $path = STORAGE_DIR . 'ProjectBackup' . DS . $backup;

        if( Folder::exists($path) )
        {
            Folder::delete($path);
        }

        Redirect::location((string) URL::prev(), 0, ['success' => LANG['success']]);
    }

    /**
     * Lang
     */
    public function lang($lang = NULL)
    {
        Lang::set($lang);

        Redirect::location((string) URL::prev());
    }

    /**
     * Project
     */
    public function project($project = NULL)
    {
        Session::insert('project', $project);
        Redirect::location((string) URL::prev());
    }

    /**
     * Editor Theme
     */
    public function editorTheme($theme = NULL)
    {
        Cookie::insert('editorTheme', $theme);
        Redirect::location((string) URL::prev());
    }
}