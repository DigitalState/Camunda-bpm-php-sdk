<?php
/**
 * Copyright 2013 camunda services GmbH
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 *limitations under the License.
 *
 * Created by IntelliJ IDEA.
 * User: hentschel
 * Date: 29.05.13
 * Time: 08:40
 * To change this template use File | Settings | File Templates.
 */

namespace org\camunda\php\sdk;

/**
 * representing the camunda rest api
 *
 * Class camundaAPI
 * @package org\camunda\php\sdk
 */
class camundaRestClient {

  private $engineUrl;
  private $cookieFilePath = './';
//  private $isAuthenticated;
//  private $sessionId;

  /**
   * @param String $engineUrl - URL of the rest api
   */
  public function __construct($engineUrl) {
    $this->engineUrl = $engineUrl;
  }

  /**
   * @param String $engineUrl url to rest api
   */
  public function setEngineUrl($engineUrl) {
    $this->engineUrl = $engineUrl;
  }

  /**
   * @return mixed url to rest api
   */
  public function getEngineUrl() {
    return $this->engineUrl;
  }
  /**
   * authenticate to use REST-API. This feature is actually not implemented
   * in the REST Api so that we don't need to do anything here until the
   * final release of camunda BPM 7.0.0
   *
   * @param $authenticationData array with username, password (, APIkey)
   */
  public function authenticate($authenticationData) {
      // not used
  }


/*---------------------- PROCESS ENGINE -------------------------------------*/

  /**
   * Retrieves the names of all process engines available on your platform.
   * @link http://docs.camunda.org/api-references/rest/#!/engine/get-names
   *
   * @return mixed  returns the server response
   */
  public function getEngineNames() {
    $query = 'engine';
    return $this->restGetRequest($query, null);
  }


/*---------------------- PROCESS INSTANCES -------------------------------------*/

  /**
   * get a single process instance from the REST API
   * @link http://docs.camunda.org/api-references/rest/#!/process-instance/get
   *
   * @param String $id Id of the process instance
   * @return mixed  returns the server response
   */
  public function getSingleProcessInstance($id) {
    $query = 'process-instance/'.$id;
    return $this->restGetRequest($query, null);
  }

  /**
   * get all process instances from the REST API
   *@link http://docs.camunda.org/api-references/rest/#!/process-instance/get-query
   *
   * @param Array $parameterArray
   * @return mixed returns the server response
   */
  public function getProcessInstances($parameterArray = null) {
    $query = 'process-instance';
    return $this->restGetRequest($query, $parameterArray);
  }

  /**
   * get count of all requested process instances
   * @link http://docs.camunda.org/api-references/rest/#!/process-instance/get-query-count
   *
   * @param Array $parameterArray
   * @return mixed returns the server response
   */
  public function getProcessInstanceCount($parameterArray = null) {
    $query = 'process-instance/count';
    return $this->restGetRequest($query, $parameterArray);
  }

  /**
   * get all process instances with POST-Request
   * @link http://docs.camunda.org/api-references/rest/#!/process-instance/post-query
   *
   * @param Array $parameterArray
   * @return mixed returns the server response
   */
  public function getProcessInstanceByPost($parameterArray = null) {
    $query = 'process-instance';
    return $this->restPostRequest($query, $parameterArray);
  }

  /**
   * get count of all requested process instances with POST-Request
   * @link http://docs.camunda.org/api-references/rest/#!/process-instance/post-query-count
   *
   * @param Array $parameterArray
   * @return mixed returns the server response
   */
  public function getProcessInstanceCountByPost($parameterArray = null) {
    $query = 'process-instance/count';
    return $this->restPostRequest($query, $parameterArray);
  }


  /**
   * Retrieves a variable of a given process instance.
   * @Link http://docs.camunda.org/api-references/rest/#!/process-instance/get-single-variable
   *
   * @param String $id
   * @param String $varId
   * @param Array $parameterArray
   * @return mixed returns the server response
   */
  public function getSingleProcessVariable($id, $varId, $parameterArray = null) {
    $query = 'process-instance/'.$id.'/variables/'.$varId;
    return $this->restGetRequest($query, $parameterArray);
  }

  /**
   * Sets a variable of a given process instance.
   * @Link http://docs.camunda.org/api-references/rest/#!/process-instance/put-single-variable
   *
   * @param String $id Process-Instance ID
   * @param String $varId Variable ID
   * @param mixed $value Variable value
   */
  public function putSingleProcessVariable($id, $varId, $value) {
    $query = 'process-instance/'.$id.'/variables/'.$varId;
    $this->restPutRequest($query, $value);
  }

  /**
   * Deletes a variable of a given process instance.
   * @Link http://docs.camunda.org/api-references/rest/#!/process-instance/delete-single-variable
   *
   * @param String $id Process-Instance ID
   * @param String $varId Variable ID
   */
  public function deleteSingleProcessVariable($id, $varId) {
    $query = 'process-instance/'.$id.'/variables/'.$varId;
    $this->restDeleteRequest($query);
  }

  /**
   * Retrieves all variables of a given process instance.
   * @link http://docs.camunda.org/api-references/rest/#!/process-instance/get-variables
   *
   * @param String $id Id of the process instance
   * @return mixed  returns the server response
   */
  public function getProcessVariables($id) {
    $query = 'process-instance/'.$id.'/variables';
    return $this->restGetRequest($query, null);
  }

  /**
   * Updates or deletes the variables of a process instance.
   * Updates precede deletes. So if a variable is updated AND deleted, the deletion overrides the update.
   * @Link http://docs.camunda.org/api-references/rest/#!/process-instance/post-variables
   *
   * @param String $id Process-Instance ID
   * @param Array $parameterArray Request Parameters
   */
  public function updateOrRemoveProcessVariables($id, $parameterArray) {
    $query = 'process-instance/'.$id.'/variables';
    $this->restPostRequest($query, $parameterArray);
  }

  /**
   * Deletes a running process instance.
   * @Link http://docs.camunda.org/api-references/rest/#!/process-instance/delete
   *
   * @param String $id Process-Instance ID
   * @param String $reason Reason for delete
   */
  public function deleteProcessInstance($id, $reason) {
    $query = 'process-instance/'.$id;
    $this->restDeleteRequest($query, $reason);
  }


/*---------------------- EXECUTIONS -------------------------------------*/

  /**
   * Retrieves a single execution according to the Execution interface in the engine
   * @link http://docs.camunda.org/api-references/rest/#!/execution/get
   *
   * @param String $id Id of the execution
   * @return mixed  returns the server response
   */
  public function getSingleExecution($id) {
    $query = 'execution/'.$id;
    return $this->restGetRequest($query, null);
  }

  /**
   * Query for the number of executions that fulfill given parameters.
   * Parameters may be static as well as dynamic runtime properties of executions.
   * @link http://docs.camunda.org/api-references/rest/#!/execution/get-query
   *
   * @param Array $parameterArray Request parameters
   * @return mixed returns the server response
   */
  public function getExecutions($parameterArray = null) {
    $query = 'execution';
    return $this->restGetRequest($query, $parameterArray);
  }

  /**
   * Query for the number of executions that fulfill given parameters.
   * @link http://docs.camunda.org/api-references/rest/#!/execution/get-query-count
   *
   * @param Array $parameterArray Request parameters
   * @return mixed returns the server response
   */
  public function getExecutionCount($parameterArray = null) {
    $query = 'execution/count';
    return $this->restGetRequest($query, $parameterArray);
  }

  /**
   * Query for executions that fulfill given parameters through a json object.
   * @link http://docs.camunda.org/api-references/rest/#!/execution/post-query
   *
   * @param Array $parameterArray Request Parameter
   * @return mixed returns the server response
   */
  public function getExecutionByPost($parameterArray = null) {
    $query = 'execution';
    return $this->restPostRequest($query, $parameterArray);
  }

  /**
   * Query for the number of executions that fulfill given parameters.
   * @link http://docs.camunda.org/api-references/rest/#!/execution/post-query-count
   *
   * @param Array $parameterArray Request parameter
   * @return mixed returns the server response
   */
  public function getExecutionCountByPost($parameterArray = null) {
    $query = 'execution/count';
    return $this->restPostRequest($query, $parameterArray);
  }

  /**
   * Retrieves a variable from the context of a given execution. Does not traverse the parent execution hierarchy.
   * @Link http://docs.camunda.org/api-references/rest/#!/execution/get-local-variable
   *
   * @param String $id execution ID
   * @param String $varId variables ID
   * @return mixed all found executions
   */
  public function getLocalExecutionVariable($id, $varId) {
    $query = 'execution/'.$id.'/localVariables/'.$varId;
    return $this->restGetRequest($query, null);
  }

  /**
   * Sets a variable in the context of a given execution. Update does not propagate upwards in the execution hierarchy.
   * @Link http://docs.camunda.org/api-references/rest/#!/execution/put-local-variable
   *
   * @param String $id execution ID
   * @param String $varId variables ID
   * @param mixed $value variables value
   */
  public function putLocalExecutionVariable($id, $varId, $value) {
    $query = 'execution/'.$id.'/localVariables/'.$varId;
    $this->restPutRequest($query, $value);
  }

  /**
   * Deletes a variable in the context of a given execution. Deletion does not propagate upwards in the
   * execution hierarchy.
   * @Link http://docs.camunda.org/api-references/rest/#!/execution/delete-local-variable
   *
   * @param $id
   * @param $varId
   */
  public function deleteLocalExecutionVariable($id, $varId) {
    $query = 'execution/'.$id.'/localVariables/'.$varId;
    $this->restDeleteRequest($query);
  }

  /**
   * Retrieves all variables of a given execution
   * @link http://docs.camunda.org/api-references/rest/#!/process-instance/get-variables
   *
   * @param String $id Id of the process instance
   * @return mixed  returns the server response
   */
  public function getLocalExecutionVariables($id) {
    $query = 'execution/'.$id.'/localVariables';
    return $this->restGetRequest($query, null);
  }

  /**
   * Updates or deletes the variables in the context of an execution. The updates do not propagate upwards in the
   * execution hierarchy. Updates precede deletes. So if a variable is updated AND deleted, the deletion overrides
   * the update.
   * @Link http://docs.camunda.org/api-references/rest/#!/execution/post-local-variables
   *
   * @param String $id execution ID
   * @param Array $parameterArray Request parameters
   */
  public function updateOrRemoveLocalExecutionVariables($id, $parameterArray) {
    $query = 'execution/'.$id.'/localVariables';
    $this->restPostRequest($query, $parameterArray);
  }

  /**
   * Get a message event subscription for a specific execution and a message name.
   * @Link http://docs.camunda.org/api-references/rest/#!/execution/get-message-subscription
   *
   * @param String $id
   * @param String $messageName
   */
  public function getMessageEventSubscription($id, $messageName) {
    $query = 'execution/'.$id.'/messageSubscriptions/'.$messageName;
    $this->restGetRequest($query, null);
  }

  /**
   * Deliver a message to a specific execution to trigger an existing message event subscription.
   * Inject process variables as the message's payload.
   *
   * @param String $id
   * @param String $messageName
   * @param Array $parameterArray
   */
  public function triggerMessageEventSubscription($id, $messageName, $parameterArray) {
    $query = 'execution/'.$id.'/messageSubscriptions/'.$messageName.'/trigger';
    $this->restPostRequest($query, $parameterArray);
  }

  /**
   * Signals a single execution. Can for example be used to explicitly skip user tasks or signal asynchronous
   * continuations.
   * @Link http://docs.camunda.org/api-references/rest/#!/execution/post-signal
   *
   * @param String $id
   * @param Array $parameterArray Request Parameter
   */
  public function triggerExecution($id, $parameterArray) {
    $query = 'execution/'.$id.'/signal';
    $this->restPostRequest($query, $parameterArray);
  }


/*---------------------- PROCESS DEFINITIONS -------------------------------------*/

  /**
   * get a single process definition from the REST API
   * @link http://docs.camunda.org/api-references/rest/#!/process-definition/get
   *
   * @param String $id Id of the process definition
   * @return mixed  returns the server response
   */
  public function getSingleProcessDefinition($id) {
    $query = 'process-definition/'.$id;
    return $this->restGetRequest($query, null);
  }

  /**
   * get all process definitions from the REST API
   * @link http://docs.camunda.org/api-references/rest/#!/process-definition/get-query
   *
   * @param Array $parameterArray
   * @return mixed returns the server-response
   */
  public function getProcessDefinitions($parameterArray = null) {
    $query = 'process-definition';
    return $this->restGetRequest($query, $parameterArray);
  }

  /**
   * get count of all requested process definitions
   * @link http://docs.camunda.org/api-references/rest/#!/process-definition/get-query-count
   *
   * @param Array $parameterArray
   * @return mixed returns the server response
   */
  public function getProcessDefinitionCount($parameterArray = null) {
    $query = 'process-definition/count';
    return $this->restGetRequest($query, $parameterArray);
  }

  /**
 * Retrieves the BPMN 2.0 XML of this process definition.
 * @link http://docs.camunda.org/api-references/rest/#!/process-definition/get-xml
 *
 * @param String $id id of the process definition
 * @return mixed returns the server response
 */
  public function getBpmnXml($id) {
    $query = 'process-definition/'.$id.'/xml';
    return $this->restGetRequest($query, null);
  }

  /**
   * Instantiates a given process definition. Process variables may be supplied in the request body.
   * @link http://docs.camunda.org/api-references/rest/#!/process-definition/post-start-process-instance
   *
   * @param String $id id of the process definition
   * @param Array $processVariables variables attached to the process instance
   * @return mixed returns the server response
   */
  public function startProcessInstance($id, $processVariables = null) {
    $query = 'process-definition/'.$id.'/start';
    return $this->restPostRequest($query, $processVariables);
  }

  /**
   * Retrieves runtime statistics of the process engine grouped by process definitions.
   * These statistics include the number of running process instances and optionally the number of failed jobs.
   * @link http://docs.camunda.org/api-references/rest/#!/process-definition/get-statistics
   *
   * @param Array $parameterArray parameters
   * @return mixed returns the server response
   */
  public function getProcessInstanceStatistics($parameterArray = null) {
    $query = 'process-definition/statistics';
    return $this->restGetRequest($query, $parameterArray);
  }

  /**
   * Retrieves runtime statistics of a given process definition grouped by activities.
   * These statistics include the number of running activity instances and optionally the number of failed jobs.
   * @link http://docs.camunda.org/api-references/rest/#!/process-definition/get-activity-statistics
   *
   * @param String $id id of the process definition
   * @param Array $parameterArray parameters
   * @return mixed returns the server response
   */
  public function getActivityInstanceStatistics($id, $parameterArray = null) {
    $query = 'process-definition/'.$id.'/statistics';
    return $this->restGetRequest($query, $parameterArray);
  }

  /**
   * Retrieves the key of the start form for a process definition. The form key corresponds to the FormData#formKey
   * property in the engine
   * @link http://docs.camunda.org/api-references/rest/#!/process-definition/get-start-form-key
   *
   * @param String $id id of the process definition
   * @return mixed returns the server response
   */
  public function getStartFormKey($id) {
    $query = '/process-definition/'.$id.'/startForm';
    return $this->restGetRequest($query, null);
  }


/*---------------------- TASK OPERATIONS -------------------------------------*/

  /**
   * Retrieves a single task by its id.
   * @link http://docs.camunda.org/api-references/rest/#!/task/get
   *
   * @param String $id task id
   * @return mixed
   */
  public function getSingleTask($id) {
    $query = 'task/'.$id;
    return $this->restGetRequest($query, null);
  }

  /**
   * get all tasks from the rest api
   * @link http://docs.camunda.org/api-references/rest/#!/task/get-query
   *
   * @param Array $parameterArray url parameter
   * @return mixed returns the server-response
   */
  public function getTasks($parameterArray = null) {
    $query = 'task';
    return $this->restGetRequest($query, $parameterArray);
  }

  /**
   * get count of all requested process definitions
   * @link http://docs.camunda.org/api-references/rest/#!/task/get-query-count
   *
   * @param Array $parameterArray url parameter
   * @return mixed returns the server response
   */
  public function getTaskCount($parameterArray = null) {
    $query = 'task/count';
    return $this->restGetRequest($query, $parameterArray);
  }

  /**
   * get all tasks from the rest api with POST-Request
   * @link http://docs.camunda.org/api-references/rest/#!/task/post-query
   *
   * @param Array $parameterArray url parameter
   * @return mixed returns the server-response
   */
  public function getTasksByPost($parameterArray = null) {
    $query = 'task';
    return $this->restPostRequest($query, $parameterArray);
  }

  /**
   * get count of all requested process definitions with POST-Request
   * @link http://docs.camunda.org/api-references/rest/#!/task/post-query-count
   *
   * @param Array $parameterArray url parameter
   * @return mixed returns the server response
   */
  public function getTaskCountByPost($parameterArray = null) {
    $query = 'task/count';
    return $this->restPostRequest($query, $parameterArray);
  }

  /**
   * Retrieves the form key for a task. The form key corresponds to the FormData#formKey property in the engine.
   * This key can be used to do task-specific form rendering in client applications.
   * @link http://docs.camunda.org/api-references/rest/#!/task/get-form-key
   *
   * @param String $id id of the task
   * @return mixed returns the server response
   */
  public function getFormKey($id) {
    $query = 'task/'.$id.'/form';
    return $this->restGetRequest($query, null);
  }

  /**
   * Claim a task for a specific user.
   * @link http://docs.camunda.org/api-references/rest/#!/task/post-claim
   *
   * @param String $id id of the task
   * @param Array $parameterArray url parameter
   * @return mixed returns the server response
   */
  public function claimTask($id,$parameterArray) {
    $query = 'task/'.$id.'/claim';
    return $this->restPostRequest($query, $parameterArray);
  }

  /**
   * Resets a task's assignee. If successful, the task is not assigned to a user.
   * @link http://docs.camunda.org/api-references/rest/#!/task/post-unclaim
   *
   * @param String $id id of the task
   * @return mixed returns the server response
   */
  public function unclaimTask($id) {
    $query = 'task/'.$id.'/unclaim';
    return $this->restPostRequest($query, null);
  }

  /**
 * Complete a task and update process variables.
 * @link http://docs.camunda.org/api-references/rest/#!/task/post-complete
 *
 * @param String $id id of the task
 * @param Array $parameterArray url parameter
 * @return mixed returns the server response
 */
  public function completeTask($id,$parameterArray) {
    $query = 'task/'.$id.'/complete';
    return $this->restPostRequest($query, $parameterArray);
  }

  /**
   * Resolve a task and update execution variables.
   * @link http://docs.camunda.org/api-references/rest/#!/task/post-resolve
   *
   * @param String $id id of the task
   * @param Array $parameterArray url parameter
   * @return mixed returns the server response
   */
  public function resolveTask($id,$parameterArray) {
    $query = 'task/'.$id.'/resolve';
    return $this->restPostRequest($query, $parameterArray);
  }

  /**
   * Delegate a task to another user.
   * @link http://docs.camunda.org/api-references/rest/#!/task/post-delegate)
   *
   * @param String $id id of the task
   * @param Array $parameterArray url parameter
   * @return mixed returns the server response
   */
  public function delegateTask($id,$parameterArray) {
    $query = 'task/'.$id.'/delegate';
    return $this->restPostRequest($query, $parameterArray);
  }


/*---------------------- MESSAGE OPERATIONS -------------------------------------*/

  /**
   * Deliver a message to the process engine to either trigger a message start or intermediate message catching event.
   * @link http://docs.camunda.org/api-references/rest/#!/message/post-message
   *
   * @param Array $parameterArray url parameter
   * @return mixed returns the server response
   */
  public function message($parameterArray) {
    $query = 'message';
    return $this->restPostRequest($query, $parameterArray);
  }


/*---------------------- IDENTITY OPERATIONS -------------------------------------*/

  /**
   * Gets the groups of a user and all users that share a group with the given user.
   * @link http://docs.camunda.org/api-references/rest/#!/identity/get-group-info
   *
   * @param Array $parameterArray url parameter
   * @return mixed returns the server-response
   */
  public function getUserGroups($parameterArray) {
    $query = '/identity/groups';
    return $this->restGetRequest($query, $parameterArray);
  }


/*---------------------- REQUEST OPERATIONS -------------------------------------*/
  /**
   * requests the data from the rest api as GET-REQUEST via curl or with stream api fallback
   *
   * @param String $query asked query of the rest api
   * @param Array $parameterArray parameters for filter
   * @return mixed returns the server-response
   */
  private function restGetRequest($query, $parameterArray) {
    $requestString = '/'. $query;


    if($parameterArray != null && !empty($parameterArray)) {
      $requestString .= '?';
      $i = 0;
      $countParameters = count($parameterArray);

      foreach($parameterArray AS $id => $value) {
        if($i == ($countParameters - 1)) {
          $requestString .= $id.'='.$value;
        } else {
          $requestString .= $id.'='.$value.'&';
          $i++;
        }
      }
    }
    if($this->checkCurl()) {
      $ch = curl_init($this->engineUrl.$requestString);
      curl_setopt ($ch, CURLOPT_COOKIEJAR, $this->cookieFilePath);
      curl_setopt ($ch, CURLOPT_COOKIEFILE, $this->cookieFilePath);
      curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);

      $request = curl_exec($ch);
      curl_close($ch);
    } else {
     $request = file_get_contents($this->engineUrl.$requestString);
    }
      return json_decode($request);
  }

  /**
   * requests the data from the rest api as POST-REQUEST via curl or with stream api fallback
   *
   * @param String $query asked query of the rest api
   * @param Array $parameterArray parameters for filter
   * @return mixed returns the server-response
   */
  private function restPostRequest($query, $parameterArray) {
    if($parameterArray == null ||empty($parameterArray)) {
      $dataString = '{}';
    } else {
      $dataString = json_encode($parameterArray);
    }
    $requestString = '/'.$query;


    if($this->checkCurl()) {
      $ch = curl_init($this->engineUrl.$requestString);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
      curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: '.strlen($dataString)
      ));

      $request = curl_exec($ch);
      echo $request;
      curl_close($ch);
    } else {
      $streamContext = stream_context_create(array(
          'http' => array(
            'method' => 'POST',
            'header' => 'Content-Type: application/json'."\r\n"
                        .'Content-Length:'.strlen($dataString)."\r\n",
            'content' => $dataString
          )
        )
      );

      $request = file_get_contents($this->engineUrl.$requestString, null, $streamContext);
    }

    return json_decode($request);

  }

  /**
   * requests the data from the rest api as POST-REQUEST via curl or with stream api fallback
   *
   * @param String $query asked query of the rest api
   * @param String $value Put parameters
   * @return mixed returns the server-response
   */
  private function restPutRequest($query, $value) {
    $dataString = '{"value":'.$value.'}';


    if($this->checkCurl()) {
      $ch = curl_init($this->engineUrl.$query);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
      curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: '.strlen($dataString)
      ));

      $request = curl_exec($ch);
      echo $request;
      curl_close($ch);
    } else {
      $streamContext = stream_context_create(array(
          'http' => array(
            'method' => 'PUT',
            'header' => 'Content-Type: application/json'."\r\n"
                .'Content-Length:'.strlen($dataString)."\r\n",
            'content' => $dataString
          )
        )
      );

      $request = file_get_contents($this->engineUrl.$query, null, $streamContext);
    }

    return json_decode($request);

  }

  /**
   * requests a deletion of data from the REST API via DELETE
   *
   * @param String $query asked query of the rest api
   * @param String $value Reason of deletion (optional
   * @return mixed returns the server-response
   */
  private function restDeleteRequest($query, $value = '') {
    if(!empty($value)) {
      $dataString = '{"deleteReason":'.$value.'}';

      if($this->checkCurl()) {
        $ch = curl_init($this->engineUrl.$query);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          'Content-Type: application/json',
          'Content-Length: '.strlen($dataString)
        ));

        $request = curl_exec($ch);
        echo $request;
        curl_close($ch);
      } else {
        $streamContext = stream_context_create(array(
            'http' => array(
              'method' => 'PUT',
              'header' => 'Content-Type: application/json'."\r\n"
                  .'Content-Length:'.strlen($dataString)."\r\n",
              'content' => $dataString
            )
          )
        );

        $request = file_get_contents($this->engineUrl.$query, null, $streamContext);
      }
    } else {
      if($this->checkCurl()) {
        $ch = curl_init($this->engineUrl.$query);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');

        $request = curl_exec($ch);
        echo $request;
        curl_close($ch);
      } else {
        $streamContext = stream_context_create(array(
            'http' => array(
              'method' => 'PUT'
            )
          )
        );

        $request = file_get_contents($this->engineUrl.$query, null, $streamContext);
      }
    }

    return json_decode($request);

  }

  private function checkCurl() {
    return function_exists('curl_version');
  }
}