# CustomID for MantisBT

## Overview
CustomID is a plugin for Mantis Bug Tracker (MantisBT) that allows administrators to customize prefixes for issue IDs (bug_id) in their MantisBT installation. 
This plugin is particularly useful for organizations that need a custom numbering format per Project or want to introduce additional logic to issue ID generation.

## Features
- Customizable issue ID prefix.
- Seamless integration with MantisBT.
- Fully compatible with MantisBT 2.x.

## Version
**Current Version**: 0.3  
**Updates**: Compatibility with MantisBT 2.x.

## Requirements
- **MantisBT**: Version 2.x or later.

## Installation
1. Download the plugin files.
2. Extract the plugin files into the `plugins` directory of your MantisBT installation.
   ```
   <mantisbt-root>/plugins/CustomID
   ```
3. Log in to MantisBT as an administrator.
4. Navigate to **Manage** > **Manage Plugins**.
5. Locate the "CustomID" plugin in the list and click **Install**.
6. Configure the plugin settings as needed.

## Configuration
Once installed, you can configure the plugin by navigating to **Manage** > **Manage Plugins** > **CustomID Settings**. Here you can define your desired ID format and rules.

## Usage
After installation and configuration, CustomID will automatically apply the custom issue ID format to all new issues created in MantisBT.
