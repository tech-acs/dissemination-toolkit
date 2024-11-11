<?php

namespace Uneca\DisseminationToolkit\Livewire\VisualizationTraits;

trait WizardStepActionTrait
{
    public function nextStep(): void
    {
        if ($this->currentStep < count($this->steps)) {
            $validator = $this->makeValidator($this->currentStep);
            if ($validator->passes()) {
                $this->currentStep++;
            } else {
                $errors = $validator->errors();
                foreach ($errors->all() as $error) {
                    $this->dispatch('notify', content: $error, type: 'error');
                }
            }
        }
    }

    public function previousStep(): void
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }
}
