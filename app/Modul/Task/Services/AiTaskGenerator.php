<?php

namespace App\Modul\Task\Services;

use App\Modul\Task\Model\Task;
use App\Modul\Tiket\Model\Tiket;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class AiTaskGenerator
{
    /**
     * Analyze text input (Chat or Ticket) and propose Tasks
     */
    public function analyzeAndProposeTasks($content, $sourceType, $sourceId)
    {
        // 1. Construct Prompt for LLM
        $prompt = "Analyze the following support request and extract actionable tasks.
                   Return JSON format with: title, description, priority (low/med/high), suggested_due_hours.
                   
                   Context: $sourceType #$sourceId
                   Content: $content";

        // 2. Call LLM Service (Mocked here - replace with actual OpenAI/Gemini call)
        $aiResponse = $this->callLLM($prompt);

        // 3. Process Response
        $tasksToCreate = [];
        foreach ($aiResponse['tasks'] as $pTask) {
             $tasksToCreate[] = [
                 'title' => $pTask['title'],
                 'description' => $pTask['description'],
                 'priority' => $pTask['priority'],
                 'due_at' => now()->addHours($pTask['suggested_due_hours']),
                 'source_type' => $sourceType,
                 'source_id' => $sourceId,
                 'ai_metadata' => ['confidence' => 0.95, 'reasoning' => 'Detected distinct action item']
             ];
        }

        return $tasksToCreate;
    }

    public function createFromTiket(Tiket $tiket)
    {
        // Auto-generation logic trigger
        $tasks = $this->analyzeAndProposeTasks(
            $tiket->deskripsi ?? 'No description', // Adjust field name based on Tiket model
            'ticket',
            $tiket->id
        );

        foreach ($tasks as $data) {
            Task::create([
                'uuid' => Str::uuid(),
                'title' => $data['title'],
                'description' => $data['description'],
                'priority' => $data['priority'],
                'status' => 'pending',
                'due_at' => $data['due_at'],
                'tiket_id' => $data['source_id'],
                'is_ai_generated' => true,
                'ai_metadata' => $data['ai_metadata']
            ]);
        }
    }

    private function callLLM($prompt) {
        // Pseudo-code for LLM integration
        // return OpenAI::chat()->create(...)
        return [
            'tasks' => [
               [
                   'title' => 'Investigate Issue', 
                   'description' => 'Check server logs based on ticket.', 
                   'priority' => 'high', 
                   'suggested_due_hours' => 4
               ]
            ]
        ];
    }
}
